<?php
/**
 * Single Listing Video
 *
 * @package WP Pro Real Estate 7
 * @subpackage Include
 */

 do_action('before_single_listing_video');

$ct_source = get_post_meta($post->ID, 'source', true);
            
$ct_video_url = get_post_meta($post->ID, "_ct_video", true);
$ct_embed_code = wp_oembed_get( $ct_video_url );

if(!empty($ct_video_url) && strpos($ct_video_url, 'http://') !== 0) {
	
	echo '<!-- Video -->';
	echo '<div id="listing-video" class="videoplayer marB20">';
		echo '<h4 class="border-bottom marB18">' . __('Video', 'contempo') . '</h4>';

		if($ct_source == 'idx-api') {
			echo '<div class="fluid-width-video-wrapper" style="padding-top: 56.25%;">';
				echo '<iframe src="' . esc_url($ct_video_url) . '"></iframe>';
			echo '</div>';
		} else {
        	print($ct_embed_code);
		}
		
	echo '</div>';
	echo '<!-- //Video -->';
}

?>