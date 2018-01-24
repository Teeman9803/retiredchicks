<?php
/**
 * Created by PhpStorm.
 * User: phuongth
 * Date: 12/17/2016
 * Time: 2:51 PM
 * @var $thumbnail
 * @var $post_link
 * @var $title
 * @var $disable_link
 */

 global $post;
 global $wp_query;

 $category = get_the_category($post->ID);
 $date = get_the_date();
 $tags = get_the_tags($post->ID);
 $tag = $tags[0]->name;
 $btntext = 'Read More';

?>
<div class="grid-post-item thumbnail masonry-layout" data-thumbnail-only="1">
    <div class="thumbnail-image" data-img="<?php echo esc_url($thumbnail); ?>">
        <?php if(!empty($thumbnail)): ?>
            <img src="<?php echo esc_attr($thumbnail); ?>" alt="<?php echo esc_html($title); ?>" >
        <?php endif; ?>
				<div class="post-info">
						<?php if(!empty($tags)): ?>
                <div class="tag"><?php echo esc_html($tag); ?></div>
            <?php endif; ?>
            <?php if(!empty($title) && $tag == 'Video'): ?>
                <div class="title">
                    <?php if($disable_link != 'true'): ?>
                        <a href="<?php echo esc_attr($post_link); ?>" title="<?php echo esc_html($title); ?>"><?php echo esc_html($title); ?></a>
                    <?php else: ?>
                        <?php echo esc_html($title); ?>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
            <?php if(!empty(date) && $category[0]->name != 'Social' && $category[1]->name != 'Subscribe'): ?>
                <div class="date">
		              <i class="fa fa-clock-o"></i>
                  <?php echo esc_html($date); ?>
                </div>
            <?php endif; ?>
            <?php if(!empty(the_content())): ?>
                <div class="excerpt"><?php echo esc_html(the_content()); ?></div>
            <?php endif; ?>
            <?php
              if(get_post_type($post->ID) == 'podcast' || $tag == 'Podcast') {
                $btntext = 'Listen Now';
              } elseif ($tag == 'Initiatives') {
                $btntext = 'View All';
              } elseif ($tag == 'About Us') {
                $btntext = 'Who We Are';
              } elseif ($tag == 'Shop') {
                $btntext = 'Shop Apparel';
              } elseif ($tag == 'Video') {
                $btntext = 'Watch Now';
              }
            ?>
            <?php if(!empty(date) && ($category[0]->name == 'Social' && $category[1]->name != 'Subscribe')): ?>
                <div class="date">
                <?php echo $category[1]->name; ?>
		              <i class="fa fa-clock-o"></i>
                  <?php echo esc_html($date); ?>
                </div>
            <?php endif; ?>
            <?php if(!empty(date) && $category[0]->name != 'Social'): ?>
            <div class="read-more">
              <a href="<?php echo esc_attr($post_link); ?>" class="button small">
	              <?php echo esc_html($btntext); ?>
              </a>
	          </div>
            <?php endif; ?>
        </div>
    </div>
</div>
