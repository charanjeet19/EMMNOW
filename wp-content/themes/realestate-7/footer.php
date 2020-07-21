<?php
/**
 * Footer Template
 *
 * @package WP Pro Real Estate 7
 * @subpackage Template
 */
 
global $ct_options;

$ct_footer_widget = isset( $ct_options['ct_footer_widget'] ) ? esc_attr( $ct_options['ct_footer_widget'] ) : '';
$ct_footer_text = isset( $ct_options['ct_footer_text'] ) ? esc_attr( $ct_options['ct_footer_text'] ) : '';
$ct_footer_back_to_top = isset( $ct_options['ct_footer_back_to_top'] ) ? esc_attr( $ct_options['ct_footer_back_to_top'] ) : '';
$ct_boxed = isset( $ct_options['ct_boxed'] ) ? esc_attr( $ct_options['ct_boxed'] ) : '';

if(!empty($ct_options['ct_footer_background_img']['url'])) {
    echo '<style type="text/css">';
    echo '#footer-widgets { background-image: url(' . esc_html($ct_options['ct_footer_background_img']['url']) . '); background-repeat: no-repeat; background-position: center center; background-size: cover;}';
    echo '</style>';
}

?>
            <div class="clear"></div>
            
        </section>
        <!-- //Main Content -->

        <?php do_action('before_footer_widgets'); ?>


        <?php
	   wp_reset_postdata();

	   // IDX DISCLAIMERS HERE
        // parameters:
        // none -> function will try to determine if its a single listing page or search results.
        // single = single listing page
        // search = search results page

        if(class_exists('IDX')) {
            $oIDX = new IDX();
            $disclaimer = $oIDX->ct_idx_disclaimer_text( );

            if ( $disclaimer != "" ) {
                echo '<div class="container">';
                    echo '<div id="disclaimer" class="muted col span_12 first">';
                        print $disclaimer;
                    echo '</div>';
                echo '</div>';
            }
        }
        ?>
            
        <?php if($ct_footer_widget == 'yes') {
        echo '<!-- Footer Widgets -->';
        echo '<div id="footer-widgets">';
            echo '<div class="dark-overlay">';
                echo '<div class="container">';
        				if (is_active_sidebar('footer')) {
                            dynamic_sidebar('Footer');
                        }
                        echo '<div class="clear"></div>';
                echo '</div>';
            echo '</div>';
        echo '</div>';
        echo '<!-- //Footer Widgets -->';
        } ?>

        <?php do_action('before_footer'); ?>
        
        <!-- Footer -->
        <footer class="footer muted" style="position: relative;bottom: 0;left:0;
    right: 0;">
            <div class="container <?php if(class_exists('IDX')) { echo 'padB10'; } ?>">  

                <?php do_action('footer_before_inner'); ?>

                <?php ct_footer_nav(); ?>
                    
                <?php if($ct_footer_text) {
                    $ct_allowed_html = array(
                        'a' => array(
                            'href' => array(),
                            'title' => array()
                        ),
                        'em' => array(),
                        'strong' => array(),
                    );
                ?>
                    <p class="marB0 right"><?php echo wp_kses(stripslashes($ct_options['ct_footer_text']), $ct_allowed_html); ?>. <?php if($ct_footer_back_to_top != 'no') { echo '<a href="#top">' . esc_html( 'Back to top', 'contempo' ) . '</a>'; } ?></p>
                <?php } else { ?>
                    <p class="marB0 right">&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>, <?php esc_html_e( 'All Rights Reserved.', 'contempo' ); ?> <?php if($ct_footer_back_to_top != 'no') { echo '<a id="back-to-top" href="#top">' . esc_html_e( 'Back to top ', 'contempo' ) . '</a>'; } ?></p>
                <?php } ?>
                <div class="clear"></div>

                <?php do_action('footer_after_inner'); ?>
            </div>

	<?php

	// IDX FOOTER HERE
    if(class_exists('IDX')) {
        
        $oIDX = new IDX();
        $idxFooter = $oIDX->ct_idx_footer_text( );

        if ( $idxFooter != "" ) {
            echo '<div class="container">';
                echo $idxFooter;
                echo " - Powered by WolfNet©";
            echo '</div>';
        }
    }
    ?>
	<?php
	$current_user = wp_get_current_user();
	
	$current_user_first_name = get_user_meta( $current_user->data->ID, 'first_name', true );
	$current_user_last_name = get_user_meta( $current_user->data->ID, 'last_name', true );
	global $woocommerce;
$woocommerce->cart->empty_cart();
if(isset($_GET['service'])){
$product_id    = intval($_GET['service']);
$woocommerce->cart->add_to_cart($product_id,1);
}

// Form Utility data 
$utility_data = $wpdb->get_results("SELECT * FROM utility_form_data WHERE user_id = ".$current_user->data->ID);
$usps_data = $wpdb->get_results("SELECT * FROM usps_form_data WHERE user_id = ".$current_user->data->ID);
 echo '<pre>';
print_r($usps_data);
echo '</pre>'; 
	?>
	<script>
	
		var service_id=getParameterByName('service');
		if(service_id){
	 console.log(service_id);
}else{
    	console.log("Service Id Not Passed");
}
	

	
	function getParameterByName(name, url) {
    if (!url) url = window.location.href;
    name = name.replace(/[\[\]]/g, '\\$&');
    var regex = new RegExp('[?&]' + name + '(=([^&#]*)|&|#|$)'),
        results = regex.exec(url);
    if (!results) return null;
    if (!results[2]) return '';
    return decodeURIComponent(results[2].replace(/\+/g, ' '));
}
	
	    jQuery(document).ready(function($){
	        var user_email = '<?php echo $current_user->data->user_email; ?>';
	         var user_nicename = '<?php echo $current_user->data->user_nicename; ?>';
	         var user_fullname= '<?php echo $current_user_first_name." ".$current_user_last_name; ?>';
	         var user_id= '<?php echo $current_user->data->ID; ?>';

	         jQuery('#lguseremail').val(user_email);
	         jQuery('#lgusername').val(user_fullname);
	         jQuery('#lguser_id').val(user_id);
        
        });
		
		
		jQuery(document).ready(function($){
	        var cep = '<?php echo $utility_data[0]->cep; ?>';
	        var accno = '<?php echo $utility_data[0]->accno; ?>';
	        var action = '<?php echo $utility_data[0]->action; ?>';
	        var cgp = '<?php echo $utility_data[0]->cgp; ?>';
	        var accno1 = '<?php echo $utility_data[0]->accno1; ?>';
	        var action1 = '<?php echo $utility_data[0]->action1; ?>';
	        var gsstartdate = '<?php echo $utility_data[0]->gsstartdate; ?>';
	        var gsenddate = '<?php echo $utility_data[0]->gsenddate; ?>';
	        var water = '<?php echo $utility_data[0]->water; ?>';
	        var action2 = '<?php echo $utility_data[0]->action2; ?>';
	        var fourdigit = '<?php echo $utility_data[0]->fourdigit; ?>';

	         jQuery('#cep').val(cep);
			 jQuery('#cep').niceSelect('update'); 
	         jQuery('#accno').val(accno);
	         jQuery('#action').val(action);
			 jQuery('#action').niceSelect('update'); 
	         jQuery('#cgp').val(cgp);
			 jQuery('#cgp').niceSelect('update'); 
	         jQuery('#accno1').val(accno1);
	         jQuery('#action1').val(action1);
			 jQuery('#action1').niceSelect('update'); 
	         jQuery('#gsstartdate').val(gsstartdate);
	         jQuery('#gsenddate').val(gsenddate);
	         jQuery('#water').val(water);
	         jQuery('#action2').val(action2);
			 jQuery('#action2').niceSelect('update'); 
	         jQuery('#fourdigit').val(fourdigit);
        
        });
		
		jQuery(document).ready(function($){
	        var whoismoving = '<?php echo $usps_data[0]->whoIsMoving; ?>';
	        var firstName = '<?php echo $usps_data[0]->firstName; ?>';
	        var middleName = '<?php echo $usps_data[0]->middleName; ?>';
	        var lastName = '<?php echo $usps_data[0]->lastName; ?>';
	        var Suffix = '<?php echo $usps_data[0]->Suffix; ?>';
	        var emailAddress = '<?php echo $usps_data[0]->emailAddress; ?>';
	        var confirmEmailAddress = '<?php echo $usps_data[0]->confirmEmailAddress; ?>';
	        var phoneNumber = '<?php echo $usps_data[0]->phoneNumber; ?>';
	        var phoneType = '<?php echo $usps_data[0]->phoneType; ?>';
	        var moveType = '<?php echo $usps_data[0]->moveType; ?>';
	        var startDate = '<?php echo $usps_data[0]->startDate; ?>';
	        var endDate = '<?php echo $usps_data[0]->endDate; ?>';
	        var oldZipCode = '<?php echo $usps_data[0]->oldZipCode; ?>';
	        var oldCity = '<?php echo $usps_data[0]->oldCity; ?>';
	        var oldState = '<?php echo $usps_data[0]->oldState; ?>';
	        var oldStreet = '<?php echo $usps_data[0]->oldStreet; ?>';
	        var newZipCode = '<?php echo $usps_data[0]->newZipCode; ?>';
	        var newCity = '<?php echo $usps_data[0]->newCity; ?>';
	        var newState = '<?php echo $usps_data[0]->newState; ?>';
	        var newStreet = '<?php echo $usps_data[0]->newStreet; ?>';

	         jQuery('#whoIsMoving').val(whoismoving);
			 jQuery('#whoIsMoving').niceSelect('update'); 
	         jQuery('#firstName').val(firstName);
	         jQuery('#middleName').val(middleName);
	         jQuery('#lastName').val(lastName);
	         jQuery('#Suffix').val(Suffix);
			 jQuery('#Suffix').niceSelect('update'); 
	         jQuery('#emailAddress').val(emailAddress);
	         jQuery('#confirmEmailAddress').val(confirmEmailAddress);
	         jQuery('#phoneNumber').val(phoneNumber);
	         jQuery('#phoneType').val(phoneType);
			 jQuery('#phoneType').niceSelect('update'); 
	        // jQuery("input[name='moveType']").val(moveType);
			 jQuery("input[name='moveType'][value='"+moveType+"']").prop('checked', true);
	         jQuery('#startDate').val(startDate);
	         jQuery('#endDate').val(endDate);
	         jQuery('#oldZipCode').val(oldZipCode);
	         jQuery('#oldCity').val(oldCity);
	         jQuery('#oldState').val(oldState);
			 jQuery('#oldState').niceSelect('update'); 
	         jQuery('#oldStreet').val(oldStreet);
	         jQuery('#newZipCode').val(newZipCode);
	         jQuery('#newCity').val(newCity);
	         jQuery('#newState').val(newState);
			  jQuery('#newState').niceSelect('update'); 
	         jQuery('#newStreet').val(newStreet);

        
        });

	</script>
</footer>
        <!-- //Footer -->
        
    <?php if($ct_boxed == "boxed") {
	echo '</div>';
    echo '<!-- //Wrapper -->';
	} ?>


    <?php do_action('after_wrapper'); ?>

	<?php wp_footer(); ?>
</body>
</html>
