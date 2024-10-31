<?php
/*
	Plugin Name: Privacy WP Lite
	Plugin URI: https://privacywp.com
	Description: Make edits to the WordPress privacy notices.
	Version: 1.1.0
	License: GPLv3
	License URI: https://www.gnu.org/licenses/gpl.html
	Author: Scott DeLuzio
	Author URI: https://scottdeluzio.com
	Text Domain: privacy-wp-lite
*/
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( !defined( 'PRIVACY_WP_LITE_VERSION' ) ){
	define( 'PRIVACY_WP_LITE_VERSION', '1.1.0' );
}
if( ! defined( 'PRIVACY_WP_LITE_PLUGIN_URL' ) ) {
	define( 'PRIVACY_WP_LITE_PLUGIN_LICENSE_PAGE', 'privacy-wp-license' );		define( 'PRIVACY_WP_LITE_PLUGIN_URL', plugins_url( '', __FILE__ ) );
}
if( ! defined( 'PRIVACY_WP_LITE_PLUGIN_DIR' ) ) {
	define( 'PRIVACY_WP_LITE_PLUGIN_DIR', dirname( __FILE__ ) );
}
include_once( PRIVACY_WP_LITE_PLUGIN_DIR . '/includes/admin-menu.php' );
include_once( PRIVACY_WP_LITE_PLUGIN_DIR . '/includes/filters.php' );
include_once( PRIVACY_WP_LITE_PLUGIN_DIR . '/includes/functions.php' );
include_once( PRIVACY_WP_LITE_PLUGIN_DIR . '/includes/general.php' );
include_once( PRIVACY_WP_LITE_PLUGIN_DIR . '/includes/confirmation-messages.php' );
include_once( PRIVACY_WP_LITE_PLUGIN_DIR . '/includes/export-email-to-user.php' );
include_once( PRIVACY_WP_LITE_PLUGIN_DIR . '/includes/third-party.php' );
include_once( PRIVACY_WP_LITE_PLUGIN_DIR . '/includes/export-erase-form.php' );
include_once( PRIVACY_WP_LITE_PLUGIN_DIR . '/includes/scripts.php' );
/**
 * These sections rely on user_confirmed_action_email_content filter.
 * Ticket #44314 references the duplicate use of this filter, which makes it impossible to
 * correctly filter the content in two different contexts.
 * https://core.trac.wordpress.org/ticket/44314
 * Will revisit these as the ticket evolves.
 */
// include_once( 'includes/erase-confirmation-email.php' );
// include_once( 'includes/user-confirmed-action-email-to-admin.php' );