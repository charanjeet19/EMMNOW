<?php
/**
 * Single Listing Yelp
 *
 * @package WP Pro Real Estate 7
 * @subpackage Include
 */

global $ct_options;

$ct_yelp_api_key = isset( $ct_options['ct_yelp_api_key'] ) ? esc_html( $ct_options['ct_yelp_api_key'] ) : '';
$ct_yelp_limit = isset( $ct_options['ct_yelp_limit'] ) ? esc_html( $ct_options['ct_yelp_limit'] ) : '';

do_action('before_single_listing_yelp');
            
echo '<!-- Nearby -->';
if(!empty($ct_yelp_api_key)) {

    $ct_yelp_amenities = isset( $ct_options['ct_yelp_amenities']['enabled'] ) ? $ct_options['ct_yelp_amenities']['enabled'] : '';

    echo '<div class="listing-nearby" id="listing-nearby">';
        echo '<div class="right yelp-powered-by"><small class="muted left">' . __('powered by ', 'contempo') . '</small><img class="right yelp-logo" src="' . get_template_directory_uri() . '/images/yelp-logo-small.png" srcset="' . ct_theme_directory_uri() . '/images/yelp-logo-small@2x.png 2x" height="25" width="50" /></div>';
        echo '<h4 class="border-bottom marB20">' . __('What\'s Nearby?', 'contempo') . '</h4>';
        
        $ct_listing_street_address = get_the_title();
        $ct_listing_city = strip_tags( get_the_term_list( $wp_query->post->ID, 'city', '', ', ', '' ) );
        $ct_listing_state = strip_tags( get_the_term_list( $wp_query->post->ID, 'state', '', ', ', '' ) );
        $ct_listing_zip = strip_tags( get_the_term_list( $wp_query->post->ID, 'zipcode', '', ', ', '' ) );

        $ct_listing_address = $ct_listing_street_address . ', ' . $ct_listing_city . ', ' . $ct_listing_state . ', ' . $ct_listing_zip;

        if ($ct_yelp_amenities) :

        foreach ($ct_yelp_amenities as $field=>$value) {
        
            switch($field) {
                
                // Restaurant            
                case 'restaurant' :

                    echo '<h5><span class="restaurants"><i class="fa fa-cutlery"></span></i></span> ' . __('Restaurants', 'contempo') . '</h5>';
                    ct_query_yelp_api('restaurant', $ct_listing_address, $ct_yelp_limit);
                    
                break;

                // Coffee Shops            
                case 'coffee_shops' :

                    echo '<h5><span class="coffee"><i class="fa fa-coffee"></i></span> ' . __('Coffee Shops', 'contempo') . '</h5>';
                    ct_query_yelp_api('coffee shop', $ct_listing_address, $ct_yelp_limit);
                    
                break;

                // Coffee Shops            
                case 'grocery' :

                    echo '<h5><span class="grocery"><i class="fa fa-shopping-basket"></i></span> ' . __('Grocery', 'contempo') . '</h5>';
                    ct_query_yelp_api('grocery', $ct_listing_address, $ct_yelp_limit);
                    
                break;

                // Schools           
                case 'schools' :

                    echo '<h5><span class="education"><i class="fa fa-mortar-board"></i></span> ' . __('Education', 'contempo') . '</h5>';
                    ct_query_yelp_api('schools', $ct_listing_address, $ct_yelp_limit);
                    
                break;

                // Banks           
                case 'banks' :

                    echo '<h5><span class="bank"><i class="fa fa-bank"></i></span> ' . __('Bank', 'contempo') . '</h5>';
                    ct_query_yelp_api('banks', $ct_listing_address, $ct_yelp_limit);
                    
                break;

                // Bars           
                case 'bars' :

                    echo '<h5><span class="beer"><i class="fa fa-beer"></i></span> ' . __('Bars', 'contempo') . '</h5>';
                    ct_query_yelp_api('bars', $ct_listing_address, $ct_yelp_limit);
                    
                break;

                // Bars           
                case 'hospitals' :

                    echo '<h5><span class="hospital"><i class="fa fa-hospital-o"></i></span> ' . __('Hospitals', 'contempo') . '</h5>';
                    ct_query_yelp_api('hospitals', $ct_listing_address, $ct_yelp_limit);
                    
                break;

                // Bars           
                case 'gas_station' :

                    echo '<h5><span class="car"><i class="fa fa-car"></i></span> ' . __('Gas Stations', 'contempo') . '</h5>';
                    ct_query_yelp_api('gas stations', $ct_listing_address, $ct_yelp_limit);
                    
                break;

                // Transit Stations           
                case 'transit_station' :
                    
                    echo '<h5><span class="bus"><i class="fa fa-bus"></i></span> ' . __('Transit Stations', 'contempo') . '</h5>';
                    ct_query_yelp_api('transit_station', $ct_listing_address, $ct_yelp_limit);
                    
                break;

                // Convenience Stores          
                case 'convenience_store' :
                    
                    echo '<h5><span class="building"><i class="fa fa-building-o"></i></span> ' . __('Convenience Stores', 'contempo') . '</h5>';
                    ct_query_yelp_api('convenience_store', $ct_listing_address, $ct_yelp_limit);
                    
                break;

                // Stores          
                case 'store' :
                    
                    echo '<h5><span class="cutlery"><i class="fa fa-building-o"></i></span> ' . __('Stores', 'contempo') . '</h5>';
                    ct_query_yelp_api('store', $ct_listing_address, $ct_yelp_limit);
                    
                break;
                
                // Shopping Malls        
                case 'shopping_mall' :
                    
                    echo '<h5><span class="cutlery"><i class="fa fa-shopping-bag"></i></span> ' . __('Shopping Malls', 'contempo') . '</h5>';
                    ct_query_yelp_api('shopping_mall', $ct_listing_address, $ct_yelp_limit);
                    
                break;
                
                // Vetinary Care       
                case 'veterinary_care' :
                    
                    echo '<h5><span class="cutlery"><i class="fa fa-hospital-o"></i></span> ' . __('Veterinary Care', 'contempo') . '</h5>';
                    ct_query_yelp_api('veterinary_care', $ct_listing_address, $ct_yelp_limit);
                    
                break;
                
                // Pet Store       
                case 'pet_store' :
                    
                    echo '<h5><span class="cutlery"><i class="fa fa-paw"></i></span> ' . __('Pet Store', 'contempo') . '</h5>';
                    ct_query_yelp_api('pet_store', $ct_listing_address, $ct_yelp_limit);
                    
                break;
                
                // Park       
                case 'park' :
                    
                    echo '<h5><span class="cutlery"><i class="fa fa-tree"></i></span> ' . __('Park', 'contempo') . '</h5>';
                    ct_query_yelp_api('park', $ct_listing_address, $ct_yelp_limit);
                    
                break;

            }

        } endif;

    echo '</div>';
} else {
    echo '<div class="nomatches">';
        echo '<h5>' . __('You need to setup the Yelp Fusion API.', 'contempo') . '</h5>';
        echo '<p class="marB0">' . __('Go into Admin > Real Estate 7 Options > What\'s Nearby? > Create App', 'contempo') . '</p>';
    echo '</div>';
}
echo '<!-- // Nearby -->';

?>