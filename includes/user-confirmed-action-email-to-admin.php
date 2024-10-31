<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
add_action( 'privacy_wp_lite_admin_page_settings', 'privacy_wp_lite_user_confirmed_action_email_to_admin_settings' );
function privacy_wp_lite_user_confirmed_action_email_to_admin_settings(){
	if ( !isset( $_GET['tab'] ) ){
		return;
	}

	if ( 'user-confirmed-action-to-admin' != $_GET['tab'] ){
		return;
	}

	if ( !current_user_can( 'manage_options' ) ){

		wp_die( 'Unauthorized User' );

	}

	if ( isset( $_POST['privacy_wp_lite_settings_page_nonce'] ) && !wp_verify_nonce( $_POST['privacy_wp_lite_settings_page_nonce'], 'privacy-wp-lite-settings-page-nonce' ) ){

		wp_die( 'Nonce not verified' );

	}

	if( isset( $_POST['privacy_wp_lite_user_confirmed_action_email_to'] ) ){

		$to = sanitize_email( $_POST['privacy_wp_lite_user_confirmed_action_email_to'] );
		update_option( 'privacy_wp_lite_user_confirmed_action_email_to', $to );

	}

	if( isset( $_POST['privacy_wp_lite_user_confirmed_action_email_subject'] ) ){

		$subject = sanitize_text_field( $_POST['privacy_wp_lite_user_confirmed_action_email_subject'] );
		update_option( 'privacy_wp_lite_user_confirmed_action_email_subject', $subject );

	}

	if( isset( $_POST['privacy_wp_lite_user_confirmed_action_email_content'] ) ){

		$email_content = sanitize_textarea_field( $_POST['privacy_wp_lite_user_confirmed_action_email_content'] );
		update_option( 'privacy_wp_lite_user_confirmed_action_email_content', $email_content );

	}

	$data = array(
		'to'				=> get_option( 'privacy_wp_lite_user_confirmed_action_email_to', '' ),
		'subject'			=> get_option( 'privacy_wp_lite_user_confirmed_action_email_subject', '' ),
		'email_content'		=> get_option( 'privacy_wp_lite_user_confirmed_action_email_content', '' )
	);

	$default_subject = sprintf(
		__( '[%s] Action Confirmed: Export/Erase Personal Data', 'privacy-wp-lite' ),
		wp_specialchars_decode( get_option( 'blogname' ), ENT_QUOTES )
	 );

	?>
	<tr>
		<td style="vertical-align:top;font-weight:700;">
			<label for="privacy_wp_lite_user_confirmed_action_email_to">
				<?php _e( 'Send To:', 'privacy-wp-lite' ); ?>
			</label>
		</td>
		<td>
			<input type="text" name="privacy_wp_lite_user_confirmed_action_email_to" id="privacy_wp_lite_user_confirmed_action_email_to" value="<?php echo $data['to']; ?>" />
			<br />
			<span class="privacy_wp_instructions" id="privacy_wp_lite_user_confirmed_action_email_to_instructions"><?php echo sprintf( __( 'Enter the email address to send to. Default is: %s', 'privacy-wp-lite' ), get_site_option( 'admin_email' ) ); ?></span>

		</td>
	</tr>
	<tr>
		<td style="vertical-align:top;font-weight:700;">
			<label for="privacy_wp_lite_user_confirmed_action_email_subject">
				<?php _e( 'Email Subject:', 'privacy-wp-lite' ); ?>
			</label>
		</td>
		<td>
			<input type="text" name="privacy_wp_lite_user_confirmed_action_email_subject" id="privacy_wp_lite_user_confirmed_action_email_subject" value="<?php echo $data['subject']; ?>" />
			<br />
			<span class="privacy_wp_instructions" id="privacy_wp_lite_user_confirmed_action_email_subject_instructions"><?php echo sprintf( __( 'Enter the subject line for the email being sent to confirm the user\'s data has been erased. Default is: %s', 'privacy-wp-lite' ), $default_subject ); ?></span>

		</td>
	</tr>
	<tr>
		<td style="vertical-align:top;font-weight:700;">
			<label for="privacy_wp_lite_user_confirmed_action_email_content">
				<?php _e( 'Confirmed Action Email Content:', 'privacy-wp-lite' ); ?>
			</label>
		</td>
		<td>
			<textarea style="min-width: 75%; height: 150px;" name="privacy_wp_lite_user_confirmed_action_email_content" id="privacy_wp_lite_user_confirmed_action_email_content"><?php echo $data['email_content']; ?></textarea>
			<br />
			<span class="privacy_wp_instructions" id="privacy_wp_lite_user_confirmed_action_email_content_instructions"><?php _e( 'Enter the text you would like in the email sent to the user confirming that their personal data has been erased. The following strings can be used as placeholders:', 'privacy-wp-lite' ); ?></span>
			<ul>
		        <li>###SITENAME###           <?php _e( 'Will be replaced with the name of the site.', 'privacy-wp-lite' ); ?></li>
		        <li>###SITEURL###            <?php _e( 'Will be replaced with the URL to the site.', 'privacy-wp-lite' ); ?></li>
				<li>###USER_EMAIL###         <?php _e( 'Will be replaced with the user email for the request.', 'privacy-wp-lite' ); ?></li>
				<li>###DESCRIPTION###        <?php _e( 'Will be replaced with description of the action being performed so the user knows what the email is for.', 'privacy-wp-lite' ); ?></li>
				<li>###MANAGE_URL###         <?php _e( 'Will be replaced with the URL to manage requests.', 'privacy-wp-lite' ); ?></li>
				<li>###SITEURL###            <?php _e( 'Will be replaced with the URL to the site.', 'privacy-wp-lite' ); ?></li>
			</ul>
		</td>
	</tr>
	<?php
}