<?php
/**
 * Single Listing Features
 *
 * @package WP Pro Real Estate 7
 * @subpackage Include
 */

do_action('before_single_listing_featlist');

$ct_source = get_post_meta($post->ID, 'source', true);

//if($ct_source != 'idx-api') {
	echo '<!-- Feature List -->';
	$ct_additional_features = get_the_terms($post->ID, 'additional_features');
	if($ct_additional_features) {
	    echo '<div id="listing-features">';
	        addfeatlist();
	    echo '</div>';
	}
	echo '<!-- //Feature List -->';
//}

?>