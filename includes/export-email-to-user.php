<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
add_action( 'privacy_wp_lite_admin_page_settings', 'privacy_wp_lite_user_export_email_settings' );
function privacy_wp_lite_user_export_email_settings(){
	if ( !isset( $_GET['tab'] ) ){
		return;
	}

	if ( 'export-email-to-user' != $_GET['tab'] ){
		return;
	}

	if ( !current_user_can( 'manage_options' ) ){

		wp_die( 'Unauthorized User' );

	}

	if ( isset( $_POST['privacy_wp_lite_settings_page_nonce'] ) && !wp_verify_nonce( $_POST['privacy_wp_lite_settings_page_nonce'], 'privacy-wp-lite-settings-page-nonce' ) ){

		wp_die( 'Nonce not verified' );

	}

	if( isset( $_POST['privacy_wp_lite_personal_data_email_content'] ) ){

		$email_content = sanitize_textarea_field( $_POST['privacy_wp_lite_personal_data_email_content'] );
		update_option( 'privacy_wp_lite_personal_data_email_content', $email_content );

	}

	$data = array(
		'email_content'		=> get_option( 'privacy_wp_lite_personal_data_email_content', '' )
	);

	?>
	<tr>
		<td style="vertical-align:top;font-weight:700;">
			<label for="privacy_wp_lite_personal_data_email_content">
				<?php _e( 'Export Data Email Content:', 'privacy-wp-lite' ); ?>
			</label>
		</td>
		<td>
			<textarea style="min-width: 75%; height: 150px;" name="privacy_wp_lite_personal_data_email_content" id="privacy_wp_lite_personal_data_email_content"><?php echo $data['email_content']; ?></textarea>
			<br />
			<span class="privacy_wp_instructions" id="privacy_wp_lite_personal_data_email_content_instructions"><?php _e( 'Enter the text you would like in the email sent to the user with a link to the personal data export file. The following strings can be used as placeholders:', 'privacy-wp-lite' ); ?></span>
			<ul>
				<li>###EXPIRATION###         <?php _e( 'Will be replaced with the date when the URL will be automatically deleted.', 'privacy-wp-lite' ); ?></li>
		        <li>###LINK###               <?php _e( 'Will be replaced with the URL of the personal data export file for the user.', 'privacy-wp-lite' ); ?></li>
		        <li>###SITENAME###           <?php _e( 'Will be replaced with the name of the site.', 'privacy-wp-lite' ); ?></li>
		        <li>###SITEURL###            <?php _e( 'Will be replaced with the URL to the site.', 'privacy-wp-lite' ); ?></li>
			</ul>
		</td>
	</tr>
	<?php
}