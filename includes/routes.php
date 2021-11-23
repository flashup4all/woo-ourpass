<?php
/**
 * Register routes for the OurPass Woocommerce plugin API.
 *
 * @package OurPass
 */

// Load route base class.
require_once OURPASSWC_PATH . 'includes/routes/class-route.php';
require_once OURPASSWC_PATH . 'includes/routes/class-ourpass-data-from-cart.php';
require_once OURPASSWC_PATH . 'includes/routes/class-ourpass-data-from-product.php';
require_once OURPASSWC_PATH . 'includes/routes/class-ourpass-response-create-order.php';

/**
 * Register OurPass Woocommerce routes for the REST API.
 */
function ourpasswc_rest_api_init() {
	new OurPass_Routes_OurPass_Data_From_Cart();
	new OurPass_Routes_OurPass_Data_From_Product();
	new OurPass_Routes_OurPass_Response_Create_Order();
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
