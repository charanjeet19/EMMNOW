/**
 * CT Custom Select
 *
 * @package WP Pro Real Estate 7
 * @subpackage JavaScript
 */

jQuery.noConflict();

(function($) {
	$(document).ready(function(){

		/*-----------------------------------------------------------------------------------*/
		/* Add Custom Select */
		/*-----------------------------------------------------------------------------------*/
		
		jQuery('1select').niceSelect();
		jQuery('1select').niceSelect('update');
		
	});
	
})(jQuery);