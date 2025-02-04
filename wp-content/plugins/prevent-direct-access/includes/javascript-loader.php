<?php
/**
 *
 * Load Admin JS Resources
 *
 */

if ( ! defined( 'ABSPATH' ) ) exit;
function admin_load_js() {

	// Register Script
	wp_register_script( 'ajaxHandle', plugins_url( '../js/custom-file.js', __FILE__ ), array( 'jquery' ) );
	
	// Enqueue Script
	wp_enqueue_script( 'ajaxHandle' );

	// Localize Script
	wp_localize_script( 'ajaxHandle', 'ajax_object', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );

}
?>
