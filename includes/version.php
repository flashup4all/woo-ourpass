<?php
/**
 * Functions to check for WooCommerce and its version.
 *
 * @package Fast
 */

/**
 * Check to see if WooCommerce is installed and active.
 *
 * @return bool
 */
function ourpasswc_woocommerce_is_active() {
	if ( ! function_exists( 'is_plugin_active' ) ) {
		require_once ABSPATH . '/wp-admin/includes/plugin.php';
	}

	$wc_is_active = is_plugin_active( 'woocommerce/woocommerce.php' );

	if ( ! $wc_is_active ) {
		// Add an admin notice that WooCommerce must be active in order for Fast to work.
		add_action(
			'admin_notices',
			'ourpasswc_settings_admin_notice_woocommerce_not_installed'
		);
	}

	return $wc_is_active;
}

/**
 * Prints the error message when woocommerce isn't installed.
 */
function ourpasswc_settings_admin_notice_woocommerce_not_installed() {
	echo '<div class="error"><p><strong>' . sprintf('OurPass requires WooCommerce to be installed and active. Click %s to install WooCommerce.', '<a href="' . admin_url('plugin-install.php?tab=plugin-information&plugin=woocommerce&TB_iframe=true&width=772&height=539') . '" class="thickbox open-plugin-details-modal">here</a>') . '</strong></p></div>';
}

/**
 * Check that the WooCommerce version is greater than a particular version.
 *
 * @param string $version The version number to compare.
 *
 * @return bool
 */
function ourpasswc_woocommerce_version_is_at_least( $version ) {
	if (
		defined( 'WC_VERSION' ) &&
		version_compare( WC_VERSION, $version, '>=' )
	) {
		return true;
	}

	return false;
}
