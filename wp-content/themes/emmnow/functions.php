<?php
/**
 * Child theme functions
 *
 * When using a child theme please review the following helpful links
 * http://contempothemes.com/wp-pro-real-estate-7-shared-by-vestathemes-com-child/documentation/#childthemes
 * http://contempothemes.com/wp-pro-real-estate-7-shared-by-vestathemes-com-child/documentation/#advdev
 * http://codex.wordpress.org/Child_Themes
 *
 * Text Domain: contempo
 *
 */

/**
 * Load the parent theme style.css file
 */
function ct_child_enqueue_parent_theme_style() {
	wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
}
add_action('wp_enqueue_scripts', 'ct_child_enqueue_parent_theme_style');

/**
 * Add your custom code below this comment
 */

?>