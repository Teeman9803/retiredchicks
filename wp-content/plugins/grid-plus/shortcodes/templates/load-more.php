<?php
/**
 * Created by PhpStorm.
 * User: phuongth
 * Date: 1/5/2017
 * Time: 3:26 PM
 * @var $current_page
 * @var $data_section_id
 * @var $page_loadmore_text
 * @var $gutter
 */
$has_loadmore = false;
if (isset($item_per_page) && $item_per_page > 0) {
    $max_num_pages = floor($total_post / $item_per_page) + ($total_post % $item_per_page > 0 ? 1 : 0);
    if (($current_page) <  $max_num_pages) {
        $has_loadmore = true;
    }
}
if (!$has_loadmore) {
    return;
}
$page_loadmore_text = str_replace('&quot;', '"', $page_loadmore_text );
?>
<div class="grid-load-more-wrap text-center grid-gutter-<?php echo esc_attr($gutter); ?>" data-section-id="<?php echo esc_attr($data_section_id) ?>">
    <a href="javascript:;" class="load-more ladda-button"
       data-next-page="<?php echo esc_attr($current_page+1);?>"
       data-spinner-color="#868686"
       data-spinner-size="20"
       data-style="zoom-in"
    >
        <?php echo wp_kses_post($page_loadmore_text); ?>
    </a>
</div>