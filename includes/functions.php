<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/**
 * Determine if the current tab is active and return the appropriate styling class.
 */
function privacy_wp_lite_active_tab( $tab ){
	$active_tab = isset( $_GET[ 'tab' ] ) ? $_GET[ 'tab' ] : 'general';
	if( $tab == $active_tab || !isset( $_GET['tab'] ) && 'general' == $tab ){
		$class = 'nav-tab-active';
	} else {
		$class = '';
	}
	return $class;
}
/**
 * Handle list table actions.
 * Forked from _wp_personal_data_handle_actions() in wp-includes/user.php
 */
function privacy_wp_lite_personal_data_handle_actions() {
	if ( isset( $_POST['action'] ) ) {
		$action = isset( $_POST['action'] ) ? sanitize_key( wp_unslash( $_POST['action'] ) ) : '';
 		switch ( $action ) {
			case 'add_export_personal_data_request':
			case 'add_remove_personal_data_request':
				check_admin_referer( 'personal-data-request' );
 				if ( ! isset( $_POST['type_of_action'], $_POST['username_or_email_for_privacy_request'] ) ) {
					return __( 'Invalid action.', 'privacy-wp-lite' );
				}
				$action_type               = sanitize_text_field( wp_unslash( $_POST['type_of_action'] ) );
				$username_or_email_address = sanitize_text_field( wp_unslash( $_POST['username_or_email_for_privacy_request'] ) );
				$email_address             = '';
 				if ( ! in_array( $action_type, _wp_privacy_action_request_types(), true ) ) {
					return __( 'Invalid action.', 'privacy-wp-lite' );
				}
 				if ( ! is_email( $username_or_email_address ) ) {
					$user = get_user_by( 'login', $username_or_email_address );
					if ( ! $user instanceof WP_User ) {
						return __( 'Unable to add this request. A valid email address or username must be supplied. <a href="javascript:history.back()">Go Back</a>', 'privacy-wp-lite' );
					} else {
						$email_address = $user->user_email;
					}
				} else {
					$email_address = $username_or_email_address;
				}
 				if ( empty( $email_address ) ) {
					break;
				}
 				$request_id = wp_create_user_request( $email_address, $action_type );
 				if ( is_wp_error( $request_id ) ) {
					return $request_id->get_error_message();
					break;
				} elseif ( ! $request_id ) {
					return __( 'Unable to initiate confirmation request.', 'privacy-wp-lite' );
					break;
				}
 				wp_send_user_request( $request_id );
 				return __( 'Confirmation request initiated successfully.', 'privacy-wp-lite' );
				break;
		}
	}
}
 /**
 * Cleans up failed and expired requests before displaying the list table.
 * Forked from _wp_personal_data_cleanup_requests() in wp-includes/user.php
 */
function privacy_wp_lite_personal_data_cleanup_requests() {
	/** This filter is documented in wp-includes/user.php */
	$expires        = (int) apply_filters( 'user_request_key_expiration', DAY_IN_SECONDS );
 	$requests_query = new WP_Query( array(
		'post_type'      => 'user_request',
		'posts_per_page' => -1,
		'post_status'    => 'request-pending',
		'fields'         => 'ids',
		'date_query'     => array(
			array(
				'column' => 'post_modified_gmt',
				'before' => $expires . ' seconds ago',
			),
		),
	) );
 	$request_ids = $requests_query->posts;
 	foreach ( $request_ids as $request_id ) {
		wp_update_post( array(
			'ID'            => $request_id,
			'post_status'   => 'request-failed',
			'post_password' => '',
		) );
	}
}