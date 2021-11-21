<?php
/**
 * Display admin notices.
 *
 * @package OurPass
 */

/**
 * Check for conditions to display admin notices.
 */
function ourpasswc_maybe_display_admin_notices() {
	$ourpasswc_debug_mode        = get_option( OURPASSWC_SETTING_DEBUG_MODE, 0 );
	$ourpasswc_test_mode         = get_option( OURPASSWC_SETTING_TEST_MODE, '1' );

	if ( ! empty( $ourpasswc_debug_mode ) ) {
		add_action( 'admin_notices', 'ourpasswc_settings_admin_notice_debug_mode' );
	}

	if ( ! empty( $ourpasswc_test_mode ) ) {
		add_action( 'admin_notices', 'ourpasswc_settings_admin_notice_test_mode' );
	}
}
add_action( 'admin_init', 'ourpasswc_maybe_display_admin_notices' );

/**
 * Maybe render the OurPass "Become a Seller" CTA.
 *
 * @param string $context Optional. The context in which the CTA is to be loaded.
 */
function ourpasswc_maybe_render_cta( $context = '' ) {
	if ( empty(ourpasswc_get_public_key() && ourpasswc_get_secret_key() ) ) {
		ourpasswc_load_template( 'admin/ourpass-cta', array( 'context' => $context ) );
	}
}

/**
 * Template for printing an admin notice.
 *
 * @param string $message The message to display.
 * @param string $type    Optional. The type of message to display.
 */
function ourpasswc_admin_notice( $message, $type = 'warning' ) {
	$class = 'notice notice-' . $type;

	printf(
		'<div class="%1$s"><p>%2$s</p></div>',
		esc_attr( $class ),
		esc_html( $message )
	);
}

/**
 * Print the Test Mode admin notice.
 */
function ourpasswc_settings_admin_notice_test_mode() {
	ourpasswc_admin_notice( __( 'OurPass Checkout for WooCommerce is currently in Test Mode.') );
}

/**
 * Print the Debug Mode admin notice.
 */
function ourpasswc_settings_admin_notice_debug_mode() {
	ourpasswc_admin_notice( __( 'OurPass Checkout for WooCommerce is currently in Debug Mode.') );
}
