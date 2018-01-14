<?php
/**
 * Created by PhpStorm.
 * User: phuongth
 * Date: 12/17/2016
 * Time: 3:03 PM
 * @var $thumbnail
 * @var $post_link
 * @var $title
 * @var $img_origin
 * @var $ico_gallery
 * @var $disable_link
 */
  global $post;
  $tags = get_the_tags($post->ID);
  $tag = $tags[0]->name;

?>
<div class="grid-post-item thumbnail-title" data-post-info-class="post-info">
    <div class="thumbnail-image" data-img="<?php echo esc_url($thumbnail); ?>">
        <?php if(!empty($thumbnail)): ?>
            <img src="<?php echo esc_attr($thumbnail); ?>" alt="<?php echo esc_html($title); ?>" >
        <?php endif; ?>
        <div class="hover-outer transition-30">
            <?php if($disable_link != 'true'): ?>
                <a href="<?php echo esc_attr($post_link); ?>" title="<?php echo esc_html($title); ?>"></a>
            <?php endif; ?>
            <div class="hover-inner transition-50">
                <div class="icon-groups">
                    <?php if($disable_link != 'true'): ?>
                        <a href="<?php echo esc_attr($post_link); ?>" class="view-detail" ><i class="fa fa-play"></i></a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <div class="post-info">
        <?php if(!empty($title)): ?>
            <div class="title">
                <?php if($disable_link != 'true'): ?>
                    <a href="<?php echo esc_attr($post_link); ?>" title="<?php echo esc_html($title); ?>"><?php echo esc_html($title); ?></a>
                <?php else: ?>
                    <?php echo esc_html($title); ?>
                <?php endif; ?>
            </div>
        <?php endif; ?>
        <?php if(!empty($excerpt)): ?>
            <div class="tag"><?php echo esc_html($tag); ?></div>
        <?php endif; ?>
    </div>
</div>
