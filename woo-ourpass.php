<?php

/**
 * Plugin Name: OurPass Payment Gateway
 * Plugin URI: https://ourpass.co/wordpress-plugin
 * Description: OurPass payment gateway for WooCommerce
 * Version: 1.0.2
 * Author: OurPass 
 * Author URI: https://tools.ourpass.co
 * License: GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * WC requires at least: 3.0.0
 * WC tested up to: 5.1
 */

if (!defined('ABSPATH')) {
    exit;
}

define('OURPASSWC_PATH', plugin_dir_path(__FILE__));
define('OURPASSWC_URL', plugin_dir_url(__FILE__));
define('OURPASSWC_VERSION', '1.0.2');

// Load constants.
require_once OURPASSWC_PATH . 'includes/constants.php';

// WooCommerce version utilities.
require_once OURPASSWC_PATH . 'includes/version.php';

function ourpasswc_update_value()
{
    $hasBeenActivated = get_option('ourpasswc_next_version_activated', false);

    if (!$hasBeenActivated) 
    {
        $wc_ourpass_settings = get_option('woocommerce_ourpass_settings');

        if ($wc_ourpass_settings) {

            if (false === get_option(OURPASSWC_SETTING_TEST_MODE)) {
                update_option(OURPASSWC_SETTING_TEST_MODE, (isset($wc_ourpass_settings['testmode']) && 'yes' === $wc_ourpass_settings['testmode']) ? '1' : '0');
            }

            if (false === get_option(OURPASSWC_SETTING_TEST_PUBLIC_KEY)) {
                update_option(OURPASSWC_SETTING_TEST_PUBLIC_KEY, isset($wc_ourpass_settings['test_public_key']) ? $wc_ourpass_settings['test_public_key'] : '');
            }

            if (false === get_option(OURPASSWC_SETTING_TEST_SECRET_KEY)) {
                update_option(OURPASSWC_SETTING_TEST_SECRET_KEY, isset($wc_ourpass_settings['test_secret_key']) ? $wc_ourpass_settings['test_secret_key'] : '');
            }

            if (false === get_option(OURPASSWC_SETTING_LIVE_PUBLIC_KEY)) {
                update_option(OURPASSWC_SETTING_LIVE_PUBLIC_KEY, isset($wc_ourpass_settings['live_public_key']) ? $wc_ourpass_settings['live_public_key'] : '');
            }

            if (false === get_option(OURPASSWC_SETTING_LIVE_SECRET_KEY)) {
                update_option(OURPASSWC_SETTING_LIVE_SECRET_KEY, isset($wc_ourpass_settings['live_secret_key']) ? $wc_ourpass_settings['live_secret_key'] : '');
            }
        }
        update_option('ourpasswc_next_version_activated', true);
    }
}


// Check whether the woocommerce plugin is active.
if ( ourpasswc_woocommerce_is_active() ) {
    //Update current plugin with previous plugin value
    ourpasswc_update_value();
	// OurPass debug functions.
	require_once OURPASSWC_PATH . 'includes/debug.php';
	// WP Admin plugin settings.
	require_once OURPASSWC_PATH . 'includes/admin/settings.php';
	// Loads OurPass js and css assets.
	require_once OURPASSWC_PATH . 'includes/assets.php';
	// Loads OurPass utilities.
	require_once OURPASSWC_PATH . 'includes/utilities.php';
	// Adds OurPass Checkout button to store.
	require_once OURPASSWC_PATH . 'includes/checkout.php';
	// Registers routes for the plugin API endpoints.
	require_once OURPASSWC_PATH . 'includes/routes.php';
}

define('OURPASSWC_PLUGIN_ACTIVATED', 'ourpasswc_plugin_activated');
/**
 * Add a flag indicating that the plugin was just activated.
 */
function ourpasswc_plugin_activated()
{
    // First make sure that WooCommerce is installed and active.
    if (ourpasswc_woocommerce_is_active()) {
        // Add a flag to show that the plugin was activated.
        add_option(OURPASSWC_PLUGIN_ACTIVATED, true);
    }
}
register_activation_hook(__FILE__, 'ourpasswc_plugin_activated');