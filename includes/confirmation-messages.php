<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
add_action( 'privacy_wp_lite_admin_page_settings', 'privacy_wp_lite_confirmation_messages_settings' );
function privacy_wp_lite_confirmation_messages_settings(){
	if ( !isset( $_GET['tab'] ) ){
		return;
	}

	if ( 'confirmation-messages' != $_GET['tab'] ){
		return;
	}

	if ( !current_user_can( 'manage_options' ) ){

		wp_die( 'Unauthorized User' );

	}

	if ( isset( $_POST['privacy_wp_lite_settings_page_nonce'] ) && !wp_verify_nonce( $_POST['privacy_wp_lite_settings_page_nonce'], 'privacy-wp-lite-settings-page-nonce' ) ){

		wp_die( 'Nonce not verified' );

	}

	if( isset( $_POST['privacy_wp_lite_export_action_confirmed_message'] ) ){

		$export_content = sanitize_textarea_field( $_POST['privacy_wp_lite_export_action_confirmed_message'] );
		update_option( 'privacy_wp_lite_export_action_confirmed_message', $export_content );

	}

	if( isset( $_POST['privacy_wp_lite_erase_action_confirmed_message'] ) ){

		$erase_content = sanitize_textarea_field( $_POST['privacy_wp_lite_erase_action_confirmed_message'] );
		update_option( 'privacy_wp_lite_erase_action_confirmed_message', $erase_content );

	}

	$data = array(
		'export_content'	=> get_option( 'privacy_wp_lite_export_action_confirmed_message', '' ),
		'erase_content'		=> get_option( 'privacy_wp_lite_erase_action_confirmed_message', '' )
	);

	?>
	<tr>
		<td style="vertical-align:top;font-weight:700;">
			<label for="privacy_wp_lite_export_action_confirmed_message">
				<?php _e( 'Export Confirmation Notice:', 'privacy-wp-lite' ); ?>
			</label>
		</td>
		<td>
			<textarea style="min-width: 75%; height: 150px;" name="privacy_wp_lite_export_action_confirmed_message" id="privacy_wp_lite_export_action_confirmed_message"><?php echo $data['export_content']; ?></textarea>
			<br />
			<span class="privacy_wp_instructions" id="privacy_wp_lite_export_action_confirmed_message_instructions"><?php _e( 'Enter the text you would like shown on screen to the user after confirming their export request.', 'privacy-wp-lite' ); ?></span>
		</td>
	</tr>
	<tr>
		<td style="vertical-align:top;font-weight:700;">
			<label for="privacy_wp_lite_export_action_confirmed_message">
				<?php _e( 'Erase Confirmation Notice:', 'privacy-wp-lite' ); ?>
			</label>
		</td>
		<td>
			<textarea style="min-width: 75%; height: 150px;" name="privacy_wp_lite_erase_action_confirmed_message" id="privacy_wp_lite_erase_action_confirmed_message"><?php echo $data['erase_content']; ?></textarea>
			<br />
			<span class="privacy_wp_instructions" id="privacy_wp_lite_erase_action_confirmed_message_instructions"><?php _e( 'Enter the text you would like shown on screen to the user after confirming their erase request.', 'privacy-wp-lite' ); ?></span>
		</td>
	</tr>
	<?php
}