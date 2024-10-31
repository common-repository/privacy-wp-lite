<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
function privacy_wp_lite_scripts(){
	wp_register_script( 'privacy-wp-lite-form-scripts', PRIVACY_WP_LITE_PLUGIN_URL . '/includes/js/request-form.js', array( 'jquery' ) );
}
add_action( 'wp_enqueue_scripts', 'privacy_wp_lite_scripts' );