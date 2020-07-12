<?php
/**
 * Agents Other Listings
 *
 * @package WP Pro Real Estate 7
 * @subpackage Widget
 */

if(!function_exists('ct_AgentsOtherListings')) {
	class ct_AgentsOtherListings extends WP_Widget {

		function __construct() {
			$widget_ops = array('description' => 'Display your agents other listings, can only be used in the Listing Single sidebar as it relies on listing information to function properly.' );
			parent::__construct(false, __('CT Agents Other Listings', 'contempo'),$widget_ops);      
		}

		function widget($args, $instance) {  
			extract( $args );
			$title = $instance['title'];
			$number = $instance['number'];
			$taxonomy = $instance['taxonomy'];
			$tag = $instance['tag'];
		?>
			<?php echo $before_widget; ?>
			<?php if ($title) { echo $before_title . esc_html($title) . $after_title; }
			echo '<ul>';

			global $ct_options;
			$ct_search_results_listing_style = isset( $ct_options['ct_search_results_listing_style'] ) ? $ct_options['ct_search_results_listing_style'] : '';

			global $post;
			$author = get_the_author_meta('ID');
			$args = array(
	            'post_type' => 'listings', 
	            'order' => 'DSC',
				$taxonomy => $tag,
				'author' => $author,
				'post__not_in' => array( $post->ID ),
	            'posts_per_page' => $number,
	            'tax_query' => array(
	            	array(
					    'taxonomy'  => 'ct_status',
					    'field'     => 'slug',
					    'terms'     => 'ghost', 
					    'operator'  => 'NOT IN'
				    ),
	            )
			);

			$wp_query = new wp_query( $args ); 
	            
	        if ( $wp_query->have_posts() ) : while ( $wp_query->have_posts() ) : $wp_query->the_post(); ?>
	        
	            <li class="listing <?php echo $ct_search_results_listing_style; ?>">
		           	<figure>
		           		<?php
		           			if(has_term('featured', 'ct_status')) {
								echo '<h6 class="snipe featured">';
									echo '<span>';
										echo __('Featured', 'contempo');
									echo '</span>';
								echo '</h6>';
							}
						?>
			            <?php
			            	$status_tags = strip_tags( get_the_term_list( $wp_query->post->ID, 'ct_status', '', ' ', '' ) );
			            	$status_tags_stripped = str_replace('_', ' ', $status_tags);
			            	if($status_tags != ''){
								echo '<h6 class="snipe status ';
										$status_terms = get_the_terms( $wp_query->post->ID, 'ct_status', array() );
										if ( ! empty( $status_terms ) && ! is_wp_error( $status_terms ) ){
										    foreach ( $status_terms as $term ) {
										    	echo esc_html($term->slug) . ' ';
										    }
										}
									echo '">';
									echo '<span>';
										echo esc_html($status_tags_stripped);
									echo '</span>';
								echo '</h6>';
							}
						?>
			            <?php ct_property_type_icon(); ?>
		                <?php ct_listing_actions(); ?>
			            <?php ct_first_image_linked(); ?>
			        </figure>
			        <div class="grid-listing-info">
			            <header>
			                <h5 class="marT0 marB0"><a <?php ct_listing_permalink(); ?>><?php ct_listing_title(); ?></a></h5>
			                <?php
			                	if(taxonomy_exists('city')){
					                $city = strip_tags( get_the_term_list( $wp_query->post->ID, 'city', '', ', ', '' ) );
					            }
					            if(taxonomy_exists('state')){
									$state = strip_tags( get_the_term_list( $wp_query->post->ID, 'state', '', ', ', '' ) );
								}
								if(taxonomy_exists('zipcode')){
									$zipcode = strip_tags( get_the_term_list( $wp_query->post->ID, 'zipcode', '', ', ', '' ) );
								}
								if(taxonomy_exists('country')){
									$country = strip_tags( get_the_term_list( $wp_query->post->ID, 'country', '', ', ', '' ) );
								}
							?>
			                <p class="location marB0"><?php echo esc_html($city); ?>, <?php echo esc_html($state); ?> <?php echo esc_html($zipcode); ?> <?php echo esc_html($country); ?></p>
			            </header>
			            <p class="price marB0"><?php ct_listing_price(); ?></p>
			            <div class="propinfo">
			                <ul class="marB0">
								<?php ct_propinfo(); ?>
		                    </ul>
	                    </div>
	                    <?php ct_listing_creation_date(); ?>
	                    <?php ct_listing_grid_agent_info(); ?>
	                    <?php ct_brokered_by(); ?>
	                    	<div class="clear"></div>
			        </div>
	            </li>

	        <?php endwhile; endif; wp_reset_postdata(); ?>
			
			<?php echo '</ul>'; ?>
			
			<?php echo $after_widget; ?>   
	    <?php
	   }

	   function update($new_instance, $old_instance) {                
		   return $new_instance;
	   }

	   function form($instance) {
		   
			$taxonomies = array (
				'property_type' => 'property_type',
				'beds' => 'beds',
				'baths' => 'baths',
				'status' => 'status',
				'city' => 'city',
				'state' => 'state',
				'zipcode' => 'zipcode',
				'additional_features' => 'additional_features'
			);
			
			$title = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
			$number = isset( $instance['number'] ) ? esc_attr( $instance['number'] ) : '';
			$taxonomy = isset( $instance['taxonomy'] ) ? esc_attr( $instance['taxonomy'] ) : '';
			$tag = isset( $instance['tag'] ) ? esc_attr( $instance['tag'] ) : '';
			
			?>
			<p>
			   <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Title:','contempo'); ?></label>
			   <input type="text" name="<?php echo esc_attr($this->get_field_name('title')); ?>"  value="<?php echo esc_attr($title); ?>" class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" />
			</p>
			<p>
	            <label for="<?php echo esc_attr($this->get_field_id('number')); ?>"><?php esc_html_e('Number:','contempo'); ?></label>
	            <select name="<?php echo esc_attr($this->get_field_name('number')); ?>" class="widefat" id="<?php echo esc_attr($this->get_field_id('number')); ?>">
	                <?php for ( $i = 1; $i <= 10; $i += 1) { ?>
	                <option value="<?php echo esc_attr($i); ?>" <?php if($number == $i){ echo "selected='selected'";} ?>><?php echo esc_html($i); ?></option>
	                <?php } ?>
	            </select>
	        </p>
	        <p>
	            <label for="<?php echo esc_attr($this->get_field_id('taxonomy')); ?>"><?php esc_html_e('Taxonomy:','contempo'); ?></label>
	            <select name="<?php echo esc_attr($this->get_field_name('taxonomy')); ?>" class="widefat" id="<?php echo esc_attr($this->get_field_id('taxonomy')); ?>">
	                <?php
					foreach ($taxonomies as $tax => $value) { ?>
	                <option value="<?php echo esc_attr($tax); ?>" <?php if($taxonomy == $tax){ echo "selected='selected'";} ?>><?php echo esc_html($tax); ?></option>
	                <?php } ?>
	            </select>
	        </p>
	        <p>
			   <label for="<?php echo esc_attr($this->get_field_id('tag')); ?>"><?php esc_html_e('Tag:','contempo'); ?></label>
			   <input type="text" name="<?php echo esc_attr($this->get_field_name('tag')); ?>"  value="<?php echo esc_attr($tag); ?>" class="widefat" id="<?php echo esc_attr($this->get_field_id('tag')); ?>" />
			</p>
			<?php
		}
	} 
}

register_widget('ct_AgentsOtherListings');
?>