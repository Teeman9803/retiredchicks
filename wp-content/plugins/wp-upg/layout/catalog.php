<?php
global $post; 
global $wp_query;

$options = get_option('upg_settings');

//Get redirected sub album
$term_slug = get_query_var( 'upg_cate' );
$term = get_term_by('slug', $term_slug, 'upg_cate');
$album_name="";

if($term_slug!="")
$album_name=$term->name;

if(isset($wp_query->query_vars['user']))
	$user=sanitize_text_field($wp_query->query_vars['user']);
else if(isset($params['user']))
	$user=$params['user'];
else
	$user="";

$author = get_user_by('slug', $user);

//$output='<div class="odude-shop">
// <div id="catalog" class="row-fluid">';

$postsperpage = $options['global_perpage'];
$perrow = $options['global_perrow'];

$orderby=$options['global_order'];
$page=$options['global_page'];
$popup=$options['global_popup'];
$album="";


if(isset($params['perpage'])&&$params['perpage']>0) $postsperpage = $params['perpage'];
if(isset($params['perrow'])&&$params['perrow']>0) $perrow = $params['perrow'];

//Disable/Hide submit button from current page. It applies to all shortcode on same page.
if(isset($params['button']))
{
	
	if($params['button']=="on")
	{
		add_action( 'upg_grip_top' , 'upg_show_button', 10 , 0 );
	}
	else
	{
		add_action( 'upg_grip_top' , 'upg_hide_button', 9 , 0 );
	}
}
else
{
	if(isset($options['primary_show_image_button']) || isset($options['primary_show_youtube_button']))
	{
		add_action( 'upg_grip_top' , 'upg_show_button', 10 , 0 );
	}
}

//Show hide upg_author profile logo
$author_show=true;
if(isset($params['author']))
{
	if($params['author']=="off")
	{
		$author_show=false;
	}
}

if($term_slug!="")
	{
	$album = $term_slug;
	//echo "alubm in url ".$album;
	}
else if(isset($params['album'])) 
	{
	//echo "parameter set";	
	$album = trim($params['album']);
	
	}
else
	{
	$album=$options['global_album'];
	//echo "default from global";
	}


if(isset($params['orderby'])) $orderby = $params['orderby'];
if(isset($params['page'])) $page = $params['page'];
if(isset($params['popup'])) $popup = $params['popup'];

if(isset($params['layout']))
	$layout=trim($params['layout']);
else
	$layout=$options['global_layout'];

//if($popup=="on")
	//add_thickbox();

//query_posts('post_type=upg&posts_per_page='.$postsperpage.'&paged='.$wp_query->query_vars['paged'].'&ptype='.$ptype);
$paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;


//to list of specific user

//echo $album."----";

if($album!="")
{
$args = array(
	'post_type' => 'upg',
	'paged' => $paged,
	'posts_per_page' => $postsperpage,
	'orderby' => $orderby,
	'order'   => 'DESC',
	'author_name' => $user,
	'tax_query' => array(
		array(
			'taxonomy' => 'upg_cate',
			'field'    => 'slug',
			'terms'    => explode(',',$album),
			//'terms'    => array( 'mobile', 'sports' ),
		),
		
	),
);
}
else
	
{
	$args = array(
	'post_type' => 'upg',
	'paged' => $paged,
	'posts_per_page' => $postsperpage,
	'author_name' => $user,
);


}

//print_r($args);

$query = new WP_Query($args); 

$put="";
ob_start ();

if(file_exists(upg_BASE_DIR."/layout/grid/".$layout."/".$layout."_config.php"))
	include(upg_BASE_DIR."/layout/grid/".$layout."/".$layout."_config.php");

if($layout=="personal")
{
	if(file_exists(upg_BASE_DIR."/layout/grid/".$layout."/".get_current_blog_id()."_".$layout."_up.php"))
		include(upg_BASE_DIR."/layout/grid/".$layout."/".get_current_blog_id()."_".$layout."_up.php");
	else
		echo __('Layout Not Found. Check Settings and save update again.','wp-upg').": ".$layout;

}
else
{
	if(file_exists(upg_BASE_DIR."/layout/grid/".$layout."/".$layout."_up.php"))
		include(upg_BASE_DIR."/layout/grid/".$layout."/".$layout."_up.php");
	else
		echo __('Layout Not Found. Check Settings and save update again.','wp-upg').": ".$layout;
}
while($query->have_posts()) : $query->the_post();
$permalink=get_permalink();
$thetitle=get_the_title();
$image=upg_image_src('thumbnail',$post);
$image_large=upg_image_src('large',$post);
$image_medium=upg_image_src('medium',$post);

	if(upg_isVideo($post))
	{
		$preview_large=upg_video_preview_url(upg_isVideo($post));
		$preview_type='youtube';
	}
	else
	{
		$preview_large=$image_large;
		$preview_type='wp-upg';
	}

	
	if($layout=="personal")
	{
		if(file_exists(upg_BASE_DIR."/layout/grid/".$layout."/".get_current_blog_id()."_".$layout.".php"))
		include(upg_BASE_DIR."/layout/grid/".$layout."/".get_current_blog_id()."_".$layout.".php"); 
	}
	else
	{
		if(file_exists(upg_BASE_DIR."/layout/grid/".$layout."/$layout.php"))
		include(upg_BASE_DIR."/layout/grid/".$layout."/$layout.php"); 
	}


endwhile;

if($layout=="personal")
	{
		if(file_exists(upg_BASE_DIR."/layout/grid/".$layout."/".get_current_blog_id()."_".$layout."_down.php"))
		include(upg_BASE_DIR."/layout/grid/".$layout."/".get_current_blog_id()."_".$layout."_down.php"); 
	}
	else
	{

		if(file_exists(upg_BASE_DIR."/layout/grid/".$layout."/".$layout."_down.php"))
		include(upg_BASE_DIR."/layout/grid/".$layout."/".$layout."_down.php");
	}


//echo '</div> </div>';

echo "<br>";

if(function_exists('wp_pagenavi'))
{
	if($page=="on")
	echo "".wp_pagenavi( array( 'query' => $query ) );
}

$put=ob_get_clean (); 
wp_reset_query();
return $put;


?>


