<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
add_action( 'privacy_wp_lite_admin_page_settings', 'privacy_wp_lite_third_party_tab' );
function privacy_wp_lite_third_party_tab(){
	if ( !isset( $_GET['tab'] ) ){
		return;
	}

	if ( 'third-party' != $_GET['tab'] ){
		return;
	}

	if ( !current_user_can( 'manage_options' ) ){

		wp_die( 'Unauthorized User' );

	}
	?>
	<tr>
		<td colspan="2">
			<h2><?php _e( 'Export and Erase from Third Party Sites', 'privacy-wp-lite' ); ?></h2>
			<p><?php _e( 'When you receive an export or erase request, you need to export or erase the user\'s data from anywhere it is stored - not just your website.', 'privacy-wp-lite' ); ?></p>
			<p><?php _e( 'While the export/erase tools built-in to WordPress are great for the data that is stored on your site, they are not able to access data from third party sites.', 'privacy-wp-lite' ); ?></p>
			<p><?php _e( 'Privacy WP is a simple to use one-stop-shop plugin that allows you to easily export and erase all of your user\'s data no matter where it is stored.', 'privacy-wp-lite' ); ?></p>
			<p><?php _e( 'Privacy WP can export or erase from the following third party services:', 'privacy-wp-lite' ); ?></p>
			<ul>
				<li><?php _e( 'MailChimp', 'privacy-wp-lite' ); ?></li>
				<li><?php _e( 'ConvertKit', 'privacy-wp-lite' ); ?></li>
				<li><?php _e( 'Stripe', 'privacy-wp-lite' ); ?></li>
				<li><?php _e( 'Drip', 'privacy-wp-lite' ); ?></li>
				<li><?php _e( 'SendGrid', 'privacy-wp-lite' ); ?></li>
				<li><?php _e( 'Help Scout', 'privacy-wp-lite' ); ?></li>
				<li><?php _e( 'Insightly CRM', 'privacy-wp-lite' ); ?></li>
			</ul>
			<p><?php _e( 'With more third party services being added all the time.', 'privacy-wp-lite' ); ?></p>
			<p><a href="https://privacywp.com/downloads/privacy-wp/?utm_source=privacy-wp-lite&utm_medium=third-party-tab" class="button button-primary"><?php _e( 'Get Privacy WP Today', 'privacy-wp-lite' ); ?></a></p>
		</td>
	</tr>
	<?php
}