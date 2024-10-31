<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Request Form tab content
 */
add_action( 'privacy_wp_lite_admin_page_settings', 'privacy_wp_lite_request_form_tab' );
function privacy_wp_lite_request_form_tab(){
	if ( !isset( $_GET['tab'] ) ){
		return;
	}

	if ( 'request-form' != $_GET['tab'] ){
		return;
	}

	if ( !current_user_can( 'manage_options' ) ){

		wp_die( 'Unauthorized User' );

	}
	?>
	<tr>
		<td colspan="2">
			<h2><?php _e( 'Request Form Shortcode', 'privacy-wp-lite' ); ?></h2>
			<p><?php _e( 'Want an easier way to handle your Export and Erase requests?', 'privacy-wp-lite' ); ?></p>
			<p><?php _e( 'Use the following shortcode in your pages or posts to provide your site users a "self-serve" option for all of their data requests.', 'privacy-wp-lite' ); ?></p>
			<p><code><?php _e( '[PrivacyRequestForm]', 'privacy-wp-lite' ); ?></code></p>
			<p><?php _e( 'Users will be able to initiate an export or erase request on their own from the front end of your site. If they enter a valid email address or username, your site will send a confirmation email to them asking them to click to confirm the request just as if you initiated the request. As an administrator, you\'ll get an email once they\'ve confirmed their request so you can process it as necessary. If the user\'s email address or username is not valid no export or erase request will be initiated and the user will receive a notice on screen indicating why the request was not initiated.','privacy-wp-lite' ); ?></p>
		</td>
	</tr>
	<?php
}
/**
 * Add the shortcode and register a Gutenberg block to display the form.
 */
add_action( 'init', 'privacy_wp_lite_export_erase_form_init' );
function privacy_wp_lite_export_erase_form_init(){
	add_shortcode( 'PrivacyRequestForm', 'privacy_wp_lite_export_erase_form_render' );
}

/**
 * Display the form for an export / erase request.
 * Form is largely based off of the forms found in wp-includes/user.php
 */
function privacy_wp_lite_export_erase_form_render(){

	wp_enqueue_script( 'privacy-wp-lite-form-scripts' );

	include_once( ABSPATH . 'wp-includes/user.php' );

	$actions = privacy_wp_lite_personal_data_handle_actions();
	privacy_wp_lite_personal_data_cleanup_requests();

	if( !$actions ){
		$label	= __( 'Username or email address associated with your account on this website', 'privacy-wp-lite' );
		$action	= __( 'Request data export or removal?', 'privacy-wp-lite' );

		$output	= apply_filters( 'privacy_wp_lite_before_export_erase_form', '' );
		$output .= '<form method="post" class="privacy-wp-lite-request-form">';
		$output .= wp_nonce_field( 'personal-data-request' );
		$output .= '<div class="privacy-wp-lite-request-email-field">';
		$output .= '<label for="username_or_email_for_privacy_request">';
		$output .= apply_filters( 'privacy_wp_lite_email_field_label', $label );
		$output .= '</label>';
		$output .= '<input type="text" required id="username_or_email_for_privacy_request" name="username_or_email_for_privacy_request" />';
		$output .= '</div>';
		$output .= '<div class="privacy-wp-lite-request-type-field">';
		$output .= '<label for="action">';
		$output .= apply_filters( 'privacy_wp_lite_request_type_label', $action );
		$output .= ' <input type="radio" name="action" value="add_export_personal_data_request">';
		$output .= __( 'Export', 'privacy-wp-lite' );
		$output .= '&nbsp;<input type="radio" name="action" value="add_remove_personal_data_request">';
		$output .= __( 'Remove', 'privacy-wp-lite' );
		$output .= '</label>';
		$output .= '</div>';
		$output .= '<input type="hidden" id="type_of_action" name="type_of_action" value="" />';
		$output .= '<input type="submit" value="' . __( 'Send Request', 'privacy-wp-lite' ) . '" />';
		$output .= '</form>';
		$output .= apply_filters( 'privacy_wp_lite_after_export_erase_form', '' );
	} else {
		$output = $actions;
	}
	return $output;
}