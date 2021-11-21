<?php
/**
 * Register routes for the Fast Woocommerce plugin API.
 *
 * @package Fast
 */

// Define the API route base path.
define( 'OURPASSWC_ROUTES_BASE', 'wc/ourpass/v1' );

// Load route base class.
require_once OURPASSWC_PATH . 'includes/routes/class-route.php';
require_once OURPASSWC_PATH . 'includes/routes/class-ourpass-data-from-cart.php';
require_once OURPASSWC_PATH . 'includes/routes/class-ourpass-data-from-product.php';

// Provides an API for polling shipping options.
require_once OURPASSWC_PATH . 'includes/routes/class-shipping.php';
// Provides an API that exposes shipping zones.
require_once OURPASSWC_PATH . 'includes/routes/class-shipping-zones.php';
// Provides an API that exposes plugin info.
require_once OURPASSWC_PATH . 'includes/routes/class-plugin-info.php';
// Provides an API to add, edit, and fetch orders.
require_once OURPASSWC_PATH . 'includes/routes/class-order-post.php';
require_once OURPASSWC_PATH . 'includes/routes/class-order-get.php';
// Provides an API that exposes product attributes.
require_once OURPASSWC_PATH . 'includes/routes/class-product-attributes.php';
// Provides an API that exposes orders with refunds.
require_once OURPASSWC_PATH . 'includes/routes/class-refunds.php';
// Provides an API that exposes a list of disabled Fast webhooks.
require_once OURPASSWC_PATH . 'includes/routes/class-webhooks.php';
// Provides an API that exposes a test authorization header.
require_once OURPASSWC_PATH . 'includes/routes/class-auth-test.php';

/**
 * Register Fast Woocommerce routes for the REST API.
 */
function ourpasswc_rest_api_init() {
	// Register a utility route to get information on installed plugins.
	new OurPass_Routes_Plugin_Info();

	new OurPass_Routes_OurPass_Data_From_Cart();
	new OurPass_Routes_OurPass_Data_From_Product();

	// Register a route to collect all possible shipping locations.
	new OurPass_Routes_Shipping_Zones();

	// Register a route to calculate available shipping rates.
	// FE -> OMS -> Blender -> (pID, variantID, Shipping info, CustomerID)Plugin.
	new OurPass_Routes_Shipping();

	// Register a route to add/edit an order.
	new OurPass_Routes_Order_Post();

	// Register a route to fetch an order.
	new OurPass_Routes_Order_Get();

	// Register a route to load product attributes.
	new OurPass_Routes_Product_Attributes();

	// Register a route to get all orders with refunds.
	new OurPass_Routes_Refunds();

	// Register a route to get all disabled Fast webhooks.
	new OurPass_Routes_Webhooks();

	// Register a route to test the Authorization header.
	new OurPass_Routes_Auth_Test();
}
add_action( 'rest_api_init', 'ourpasswc_rest_api_init' );

/**
 * We have to tell WC that this should not be handled as a REST request.
 * Otherwise we can't use the product loop template contents properly.
 * Since WooCommerce 3.6
 *
 * @param bool $is_rest_api_request
 * @return bool
 */
function simulate_as_not_rest( $is_rest_api_request ) {
	if ( empty( $_SERVER['REQUEST_URI'] ) ) {
			return $is_rest_api_request;
	}

	// Bail early if this is not our request.
	if ( false === strpos( $_SERVER['REQUEST_URI'], OURPASSWC_ROUTES_BASE ) ) {
		return $is_rest_api_request;
	}

	return false;
}
add_filter('woocommerce_is_rest_api_request','simulate_as_not_rest');


/**
 * Abstract REST API permissions callback.
 *
 * @param string $capability Capability name to check.
 * @param string $log_string Initial string for the permission check log.
 *
 * @return bool
 */
function ourpasswc_api_general_permission_callback( $capability, $log_string ) {
	// Make sure an instance of WooCommerce is loaded.
	// This will load the `WC_REST_Authentication` class, which
	// handles the API consumer key and secret.
	WC();

	$has_permission = current_user_can( $capability );

	ourpasswc_log_info( $log_string . ': ' . ( $has_permission ? 'granted' : 'denied' ) );

	return $has_permission;
}

/**
 * REST API permissions callback.
 *
 * @return bool
 */
function ourpasswc_api_permission_callback() {
	return ourpasswc_api_general_permission_callback( 'manage_options', 'API Manage Options Permission Callback' );
}

/**
 * REST API permissions callback for product attributes.
 *
 * @return bool
 */
function ourpasswc_api_managewc_permission_callback() {
	return ourpasswc_api_general_permission_callback( 'manage_woocommerce', 'API Manage WooCommerce Permission Callback' );
}
