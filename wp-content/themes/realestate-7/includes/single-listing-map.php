<?php
/**
 * Single Listing Map
 *
 * @package WP Pro Real Estate 7
 * @subpackage Include
 */

global $ct_options;

$ct_driving_directions = isset( $ct_options['ct_driving_directions'] ) ? esc_html( $ct_options['ct_driving_directions'] ) : '';
$ct_latlng = get_post_meta(get_the_ID(), '_ct_latlng', true);

do_action('before_single_listing_map');
            
echo '<!-- Map -->';
echo '<div id="listing-location">';
    echo '<h4 class="border-bottom marB18">' . __('Location', 'contempo') . '</h4>';

    ct_listing_map();

    /* Driving Directions */
    if($ct_driving_directions != 'yes') {

	    echo '<form id="get-directions" action="https://maps.google.com/maps" method="get" target="_blank">';
	    	echo '<div class="col span_9 first">';
				echo '<input type="text" name="saddr" id="autocomplete" placeholder="' . __('Enter your starting address', 'contempo') . '" />';
				echo '<input type="hidden" name="daddr" value="';
					if(!empty($ct_latlng)) {
						echo esc_html($ct_latlng);
					} else {
						the_title();
						echo ' ';
						ct_taxonomy('city');
						echo ' ';
						ct_taxonomy('state');
						echo ' ';
						ct_taxonomy('zipcode');
					}
				echo '" />';
			echo '</div>';
			echo '<div class="col span_3">';
				echo '<input type="submit" value="' . __('get directions', 'contempo') . '" />';
			echo '</div>';
				echo '<div class="clear"></div>';
		echo '</form>';
	}

echo '</div>';
echo '<!-- //Map -->';

/* Auto Complete for Driving Directions */
if($ct_driving_directions != 'yes') {
	echo '<script>';
		echo "var input = document.getElementById('autocomplete');";
		echo 'var autocomplete = new google.maps.places.Autocomplete(input);';
	echo '</script>';
}

?>