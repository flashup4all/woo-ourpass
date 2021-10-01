<?php

/**
 * Plugin Name: Ourpass WooCommerce Payment Gateway
 * Plugin URI: https://ourpass.co
 * Description: WooCommerce payment gateway for Ourpass
 * Version: 1.0.0
 * Author: Ourpass
 * Author URI: https://ourpass.co
 * License: GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * WC requires at least: 3.0.0
 * WC tested up to: 5.1
 */

if (!defined('ABSPATH')) {
    exit;
}

define('WC_OURPASS_MAIN_FILE', __FILE__);
define('WC_OURPASS_URL', untrailingslashit(plugins_url('/', __FILE__)));
define('WC_OURPASS_VERSION', '1.0.0');

/**
 * Initialize Ourpass WooCommerce payment gateway.
 */
function tbz_wc_ourpass_init()
{
    if (!class_exists('WC_Payment_Gateway')) {
        add_action('admin_notices', 'tbz_wc_ourpass_wc_missing_notice');
        return;
    }

    add_action('admin_notices', 'tbz_wc_ourpass_testmode_notice');

    require_once dirname(__FILE__) . '/includes/class-wc-gateway-ourpass.php';

    add_filter('woocommerce_payment_gateways', 'tbz_wc_add_ourpass_gateway');

    add_filter('plugin_action_links_' . plugin_basename(__FILE__), 'tbz_woo_ourpass_plugin_action_links');
}
add_action('plugins_loaded', 'tbz_wc_ourpass_init', 99);


/**
 * Add Settings link to the plugin entry in the plugins menu.
 *
 * @param array $links Plugin action links.
 *
 * @return array
 **/
function tbz_woo_ourpass_plugin_action_links($links)
{

    $settings_link = array(
        'settings' => '<a href="' . admin_url('admin.php?page=wc-settings&tab=checkout&section=ourpass') . '" title="View Ourpass WooCommerce Settings">Settings</a>',
    );

    return array_merge($settings_link, $links);
}

/**
 * Add Ourpass Gateway to WooCommerce.
 *
 * @param array $methods WooCommerce payment gateways methods.
 *
 * @return array
 */
function tbz_wc_add_ourpass_gateway($methods)
{
    $methods[] = 'WC_Gateway_Ourpass';
    return $methods;
}

/**
 * Display a notice if WooCommerce is not installed
 */
function tbz_wc_ourpass_wc_missing_notice()
{
    echo '<div class="error"><p><strong>' . sprintf('Ourpass requires WooCommerce to be installed and active. Click %s to install WooCommerce.', '<a href="' . admin_url('plugin-install.php?tab=plugin-information&plugin=woocommerce&TB_iframe=true&width=772&height=539') . '" class="thickbox open-plugin-details-modal">here</a>') . '</strong></p></div>';
}

/**
 * Display the test mode notice.
 **/
function tbz_wc_ourpass_testmode_notice()
{
    if (!current_user_can('manage_options')) {
        return;
    }

    $ourpass_settings = get_option('woocommerce_ourpass_settings');
    $test_mode         = isset($ourpass_settings['testmode']) ? $ourpass_settings['testmode'] : '';

    if ('yes' === $test_mode) {
        echo '<div class="error"><p>' . sprintf('Ourpass test mode is still enabled, Click <strong><a href="%s">here</a></strong> to disable it when you want to start accepting live payment on your site.', esc_url(admin_url('admin.php?page=wc-settings&tab=checkout&section=ourpass'))) . '</p></div>';
    }
}

function dd(...$value){
    echo "<pre>";
    echo print_r($value);
    echo "</pre>";
    die();
}