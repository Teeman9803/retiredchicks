<style>
.upg-desp{
	color:#999;
	font-size:1.2em;
	
	
}
.upg-profile-name{
	color:#999;
}

.avatar {
border-radius: 50%;
-moz-border-radius: 50%;
-webkit-border-radius: 50%;
}
</style>

<div class="page type-page">
<div class="pure-g">
	
	 <div class="pure-u-1-1" style="text-align:center;"><?php echo upg_position1(); ?></div>
	
	<div class="pure-u-1 pure-u-md-3-5"> 

	<div class="margin-box">
	<?php
					 if(upg_isVideo($post))
					 {
						 $attr = array(
						'src'      => esc_url( upg_isVideo($post) ),
						'width'    => 560,
						'height'   => 315
						
						);
	
						echo wp_video_shortcode( $attr );
					 }
					else
					{
							 
						?>
					 <img src="<?php echo $image; ?>" class="pure-img">
					  <?php
					}
						 ?>
	
	
	</div>


	</div>
	
	
    <div class="pure-u-1 pure-u-md-1-5"> 


<div class="pure-u-1"><?php echo upg_get_filed_label('upg_custom_field_1'); ?> : <?php echo upg_get_value('upg_custom_field_1'); ?></div>
<div class="pure-u-1"><?php echo upg_get_filed_label('upg_custom_field_2'); ?> : <?php echo upg_get_value('upg_custom_field_2'); ?></div>
<div class="pure-u-1"><?php echo upg_get_filed_label('upg_custom_field_3'); ?> : <?php echo upg_get_value('upg_custom_field_3'); ?></div>
<div class="pure-u-1"><?php echo upg_get_filed_label('upg_custom_field_4'); ?> : <?php echo upg_get_value('upg_custom_field_4'); ?></div>
<div class="pure-u-1"><?php echo upg_get_filed_label('upg_custom_field_5'); ?> : <?php echo upg_get_value('upg_custom_field_5'); ?></div>

		<?php 
	echo upg_author($author);
	?>
	
	</div>
	
		<div class="pure-u-1"><div class="margin-box">
	
	
	<div class="upg-desp"> 	<?php echo $text; ?> </div>
	
	</div></div>
	
	<div class="pure-u-1"> <?php echo upg_position2(); ?></div>
	
</div>	
</div>