<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Filters the length of expiration for the data export file.
 * Tab: General
 */
add_filter( 'wp_privacy_export_expiration ', 'privacy_wp_lite_export_expiration_filter' );
function privacy_wp_lite_export_expiration_filter( $expiration ){
	if( '' != get_option( 'privacy_wp_lite_export_expiration', '' ) ){
		$exp		= get_option( 'privacy_wp_lite_export_expiration', '' ) * DAY_IN_SECONDS;
		$expiration	= (int)apply_filters( 'privacy_wp_lite_expiration_time_filter', $exp );
	}
	return (int)$expiration;
}

/**
 * Filters the message shown to the user on the website when they confirm exporting data.
 * Tab: Confirmation Messages
 */
add_filter( 'user_request_action_confirmed_message', 'privacy_wp_lite_export_action_confirmed_message_filter', 10, 2 );
function privacy_wp_lite_export_action_confirmed_message_filter( $message, $request_id ){
	$request = wp_get_user_request_data( $request_id );
	if ( $request && in_array( $request->action_name, _wp_privacy_action_request_types(), true ) ) {
		if ( 'export_personal_data' === $request->action_name ) {
			if( '' != get_option( 'privacy_wp_lite_export_action_confirmed_message', '' ) ){
				$message = get_option( 'privacy_wp_lite_export_action_confirmed_message', '' );
			}
		}
	}
	return $message;
}

/**
 * Filters the message shown to the user on the website when they confirm erasing data.
 * Tab: Confirmation Messages
 */
add_filter( 'user_request_action_confirmed_message', 'privacy_wp_lite_erase_action_confirmed_message_filter', 10, 2 );
function privacy_wp_lite_erase_action_confirmed_message_filter( $message, $request_id ){
	$request = wp_get_user_request_data( $request_id );
	if ( $request && in_array( $request->action_name, _wp_privacy_action_request_types(), true ) ) {
		if ( 'remove_personal_data' === $request->action_name ) {
			if( '' != get_option( 'privacy_wp_lite_erase_action_confirmed_message', '' ) ){
				$message = get_option( 'privacy_wp_lite_erase_action_confirmed_message', '' );
			}
		}
	}
	return $message;
}

/**
 * Email sent to the user with link to personal data download.
 * Tab: Export Data Email to User
 */
add_filter( 'wp_privacy_personal_data_email_content', 'privacy_wp_lite_personal_data_email_content_filter', 10, 2 );
function privacy_wp_lite_personal_data_email_content_filter( $email_text, $request_id ){
	if( '' != get_option( 'privacy_wp_lite_personal_data_email_content', '' ) ){
		$email_text = get_option( 'privacy_wp_lite_personal_data_email_content', '' );
	}
	return $email_text;
}

/**
 * The emails being sent in the following filters rely on user_confirmed_action_email_content filter.
 * Ticket #44314 references the duplicate use of this filter, which makes it impossible to
 * correctly filter the content in two different contexts.
 * https://core.trac.wordpress.org/ticket/44314
 * It is possible to include the filter for the subject line and admin to address, but it would
 * likely be confusing to do so without including the email content in these sections as well.
 * Will revisit these as the trac ticket evolves.
 */

/**
 * Email subject sent to user confirming their data has been erased.
 * Tab: Erase Confirmation Email
 */
// add_filter( 'user_erasure_complete_email_subject', 'privacy_wp_lite_erased_data_confirmation_email_subject_filter', 10, 3 );
// function privacy_wp_lite_erased_data_confirmation_email_subject_filter( $subject, $sitename, $email_data ){
// 	if( '' != get_option( 'privacy_wp_lite_erase_confirmation_email_subject', '' ) ){
// 		$subject = get_option( 'privacy_wp_lite_erase_confirmation_email_subject', '' );
// 	}
// 	return $subject;
// }

/**
 * Email content sent to user confirming their data has been erased.
 * Tab: Erase Confirmation Email
 */
// add_filter( 'user_confirmed_action_email_content', 'privacy_wp_lite_erased_data_confirmation_email_content_filter', 10, 2 );
// function privacy_wp_lite_erased_data_confirmation_email_content_filter( $email_text, $email_data ){
// 	if( 'Erase Personal Data' == $email_data['description'] ){
// 		if( '' != get_option( 'privacy_wp_lite_erase_confirmation_email_content', '' ) ){
// 			$email_text = get_option( 'privacy_wp_lite_erase_confirmation_email_content', '' );
// 		}
// 		foreach( $email_data['request'] as $key => $value){
// 			$email_text .= "$key => $value\n";
// 		}
// 	}
// 	return $email_text;
// }

/**
 * Email address to send user confirmed action notice email.
 * Tab: User Confirmed Action Email to Admin
 */
// add_filter( 'user_request_confirmed_email_to', 'privacy_wp_lite_user_confirmed_action_email_to_filter', 10, 2 );
// function privacy_wp_lite_user_confirmed_action_email_to_filter( $admin_email, $request_data ){
// 	if( '' != get_option( 'privacy_wp_lite_user_confirmed_action_email_to', '' ) ){
// 		$to = get_option( 'privacy_wp_lite_user_confirmed_action_email_to', '' );
// 		if( is_email( $to ) ){
// 			$admin_email = $to;
// 		}
// 	}
// 	return $admin_email;
// }

/**
 * Email subject sent to admin in user confirmed action notice email.
 * Tab: User Confirmed Action Email to Admin
 */
// add_filter( 'user_request_confirmed_email_subject', 'privacy_wp_lite_user_confirmed_action_email_subject_filter', 10, 3 );
// function privacy_wp_lite_user_confirmed_action_email_subject_filter( $subject, $sitename, $email_data ){
// 	if( 'remove_personal_data' == $email_data['request']->action_name ){
// 		$description = __( 'Erase Personal Data', 'privacy-wp-lite' );
// 	} else {
// 		$description = __( 'Export Personal Data', 'privacy-wp-lite' );
// 	}
// 	if( '' != get_option( 'privacy_wp_lite_user_confirmed_action_email_subject', '' ) ){
// 		$subject = get_option( 'privacy_wp_lite_user_confirmed_action_email_subject', '' );
// 		// WordPress core doesn't have a placeholder string for description in the subject text, so adding it here.
// 		$subject = str_replace( '###DESCRIPTION###', $description, $subject );
// 	}
// 	return $subject;
// }

/**
 * Email content sent to admin in user confirmed action notice email.
 * Tab: User Confirmed Action Email to Admin
 */
// add_filter( 'user_confirmed_action_email_content', 'privacy_wp_lite_user_confirmed_action_email_content_filter', 10, 2 );
// function privacy_wp_lite_user_confirmed_action_email_content_filter( $email_text, $email_data ){
// 	if( '' != get_option( 'privacy_wp_lite_user_confirmed_action_email_content', '' ) ){
// 		$email_text = get_option( 'privacy_wp_lite_user_confirmed_action_email_content', '' );
// 	}
// 	foreach( $email_data['request'] as $key => $value){
// 		$email_text .= "$key => $obj[$key]\n";
// 	}
// 	return $email_text;
// }