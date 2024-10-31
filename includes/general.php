<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
add_action( 'privacy_wp_lite_admin_page_settings', 'privacy_wp_lite_general_settings' );
function privacy_wp_lite_general_settings(){
	if ( isset( $_GET['tab'] ) && 'general' != $_GET['tab'] ){
		return;
	}

	if ( !current_user_can( 'manage_options' ) ){

		wp_die( 'Unauthorized User' );

	}

	if ( isset( $_POST['privacy_wp_lite_settings_page_nonce'] ) && !wp_verify_nonce( $_POST['privacy_wp_lite_settings_page_nonce'], 'privacy-wp-lite-settings-page-nonce' ) ){

		wp_die( 'Nonce not verified' );

	}

	if ( isset( $_POST['privacy_wp_lite_export_expiration'] ) ){

		$expiration	= (int)$_POST['privacy_wp_lite_export_expiration'];
		update_option( 'privacy_wp_lite_export_expiration', $expiration );

	}

	$data = array(
		'expiration'		=> get_option( 'privacy_wp_lite_export_expiration', 3 ),
	);

	?>
	<tr>
		<td style="vertical-align:top;font-weight:700;">
			<label for="privacy_wp_lite_export_expiration">
				<?php _e( 'Export Expiration:', 'privacy-wp-lite' ); ?>
			</label>
		</td>
		<td>
			<input type="text" name="privacy_wp_lite_export_expiration" id="privacy_wp_lite_export_expiration" value="<?php echo $data['expiration']; ?>" />
			<br />
			<span class="privacy_wp_instructions" id="privacy_wp_lite_export_expiration_instructions"><?php _e( 'Enter the number of days before the export files should be deleted. Default is 3.', 'privacy-wp-lite' ); ?></span>
		</td>
	</tr>
	<?php
}