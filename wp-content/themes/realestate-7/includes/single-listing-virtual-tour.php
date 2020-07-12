<?php
/**
 * Single Listing Virtual Tour
 *
 * @package WP Pro Real Estate 7
 * @subpackage Include
 */

do_action('before_single_listing_virtual_tour');
            
echo '<!-- Virtual Tour -->';

$ct_virtual_tour = get_post_meta($post->ID, "_ct_virtual_tour", true);
$ct_virtual_tour_shortcode = get_post_meta($post->ID, "_ct_virtual_tour_shortcode", true);
$ct_virtual_tour_url = get_post_meta($post->ID, "_ct_virtual_tour_url", true);

if(!empty($ct_virtual_tour) || !empty($ct_virtual_tour_shortcode) || !empty($ct_virtual_tour_url)) {
    echo '<div id="listing-virtual-tour" class="marB20">';
        echo '<h4 class="border-bottom marB20">' . __('Virtual Tour', 'contempo') . '</h4>';
        if(!empty($ct_virtual_tour)) {
	        echo get_post_meta($post->ID, "_ct_virtual_tour", true);
	     } elseif(!empty($ct_virtual_tour_shortcode)) {
	     	echo do_shortcode($ct_virtual_tour_shortcode);
	     } elseif(!empty($ct_virtual_tour_url)) {
	     	echo '<div class="video">';
		     	echo '<iframe src="' . $ct_virtual_tour_url . '"></iframe>';
		    echo '</div>';
	     }
    echo '</div>';
}
echo '<!-- //Virtual Tour -->';

?>