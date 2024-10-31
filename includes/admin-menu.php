<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

add_action( 'admin_menu', 'privacy_wp_lite_admin_page', 99 );
function privacy_wp_lite_admin_page() {
	$page_title	= __( 'Privacy WP Lite Settings', 'privacy-wp' );
	$menu_title	= __( 'Privacy WP Lite', 'privacy-wp' );
	$capability	= 'manage_options';
	$menu_slug	= 'privacy_wp_lite_settings';
	$function	= 'privacy_wp_lite_admin_page_callback';
	$icon_url	= 'dashicons-shield';
	$position	= 24;

	if( !defined( 'PRIVACY_WP_VERSION' ) ){
		add_menu_page( $page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position );
	} else {
		add_submenu_page( 'privacy_wp_settings', $page_title, $menu_title, $capability, $menu_slug, $function );
	}
}
if ( !function_exists( 'privacy_wp_lite_admin_page_callback' ) ){
	function privacy_wp_lite_admin_page_callback(){
		echo '<h1>' . __( 'Privacy WP Lite Settings', 'privacy-wp-lite' ) . '</h1>';
		/**
		 * The 'erase-confirmed-email-to-user' and 'user-confirmed-action-to-admin' sections rely
		 * on user_confirmed_action_email_content filter.
		 * Ticket #44314 references the duplicate use of this filter, which makes it impossible to
		 * correctly filter the content in two different contexts.
		 * https://core.trac.wordpress.org/ticket/44314
		 * Will revisit these as the ticket evolves.
		 */
		$tabs = array(
			'general'							=> __( 'General', 'privacy-wp-lite' ),
			'confirmation-messages'				=> __( 'Confirmation Messages', 'privacy-wp-lite' ),
			'export-email-to-user'				=> __( 'Export Data Email to User', 'privacy-wp-lite' ),
			'request-form'						=> __( 'Request Form', 'privacy-wp-lite' ),
			// 'erase-confirmed-email-to-user'		=> __( 'Erase Confirmation Email', 'privacy-wp-lite' ),
			// 'user-confirmed-action-to-admin'	=> __( 'User Confirmed Action Email to Admin', 'privacy-wp-lite' )
		);
		if( !defined( 'PRIVACY_WP_VERSION' ) ){
			$tabs['third-party'] = __( 'Export/Erase From 3rd Party Sites', 'privacy-wp-lite' );
		}
		$tabs = apply_filters( 'privacy_wp_lite_admin_tabs', $tabs );
		?>
		<h2 class="nav-tab-wrapper">
		<?php
		foreach( $tabs as $tab => $value ){ ?>
			<a class="nav-tab <?php echo privacy_wp_lite_active_tab( $tab ); ?>" href="?page=privacy_wp_lite_settings&tab=<?php echo $tab; ?>"><?php echo $value; ?></a>
		<?php } ?>
		</h2>
		<?php
		do_action( 'privacy_wp_lite_admin_page_before_settings' );
		?>
		<form method="POST">
			<table>
				<?php
				do_action( 'privacy_wp_lite_admin_page_settings' );
				?>
				<tr>
					<td colspan="2">
						<?php wp_nonce_field( 'privacy-wp-lite-settings-page-nonce', 'privacy_wp_lite_settings_page_nonce' ); ?>
					</td>
				</tr>
				<?php
				/**
				 * When clicking on the Privacy WP Lite menu for the first time, $_GET['tab'] is not set.
				 * After clicking on any other tab, and even the default "General" tab, $_GET['tab'] will be set.
				 * We don't want to show the save button on the third party tab.
				 */
				if( !isset( $_GET['tab'] ) || ( isset( $_GET['tab'] ) && !in_array( $_GET['tab'], array( 'third-party', 'request-form' ) ) ) ){ ?>
				<tr>
					<td colspan="2">
						<input type="submit" value="Save" class="button button-primary button-large" />
					</td>
				</tr>
				<?php } ?>
			</table>
		</form>

		<?php do_action( 'privacy_wp_lite_admin_page_after_settings' );

	}

}

