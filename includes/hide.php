<?php
/**
 * Conditions for determining if/when to hide the OurPass Checkout buttons.
 *
 * @package OurPass
 */

/**
 * Check if we should hide the OurPass Checkout PDP button.
 *
 * @param int $product_id Optional. The ID of the product.
 *
 * @return bool
 */
function ourpasswc_should_hide_pdp_checkout_button( $product_id = 0 ) {
	if ( empty( $product_id ) && is_product() ) {
		global $product;
	} elseif ( ! empty( $product_id ) ) {
		$product = wc_get_product( $product_id );
	}

	// Never show a PDP button if there is no product or if the product is a string.
	if ( empty( $product ) || is_string( $product ) ) {
		ourpasswc_log_info( 'PDP button hidden because no product: ' . $product_id );
		return true;
	}

	/**
	 * Filter to set whether or not to hide the OurPass Checkout PDP button. Returns false by default.
	 *
	 * @param bool       $should_hide Flag to pass through the filters for whether or not to hide the php checkout button.
	 * @param WC_Product $product     The WooCommerce product object.
	 *
	 * @return bool
	 */
	$should_hide = apply_filters( 'ourpasswc_should_hide_pdp_checkout_button', false, $product );

	ourpasswc_log_info( 'PDP button' . ( $should_hide ? '' : ' not' ) . ' hidden: ' . $product_id );

	return $should_hide;
}

/**
 * Check if we should hide the OurPass Checkout cart button. Returns false by default.
 *
 * @return bool
 */
function ourpasswc_should_hide_cart_checkout_button() {
	/**
	 * Filter to set whether or not to hide the OurPass Checkout cart button. Returns false by default.
	 *
	 * @param bool $should_hide Flag to pass through the filters for whether or not to hide the cart checkout button.
	 *
	 * @return bool
	 */
	$should_hide = apply_filters( 'ourpasswc_should_hide_cart_checkout_button', false );

	ourpasswc_log_info( 'Cart button' . ( $should_hide ? '' : ' not' ) . ' hidden.' );

	return $should_hide;
}

/**
 * Checks if the OurPass Checkout button should be hidden for the current user based on the Test Mode field and their email
 * The button should be hidden for all non-OurPass users if Test Mode is enabled, and should be visible for everyone if
 * Test Mode is disabled.
 *
 * @param bool $should_hide Flag from filter to hide or not hide the PDP button.
 *
 * @return bool true if we should hide the button, false otherwise
 */
function ourpasswc_is_hidden_for_test_mode( $should_hide ) {

	if ( ! $should_hide ) {
		// If test mode option is not yet set (e.g. plugin was just installed), treat it as enabled.
		// There is code in the settings page that actually sets this to enabled the first time the user views the form.
		$ourpasswc_test_mode = get_option( OURPASSWC_SETTING_TEST_MODE, '1' );

		ourpasswc_log_info( 'OurPass buttons' . ( $should_hide ? '' : ' not' ) . ' hidden for test mode.' );
	}

	return $should_hide;
}
add_filter( 'ourpasswc_should_hide_pdp_checkout_button', 'ourpasswc_is_hidden_for_test_mode', 1 );
add_filter( 'ourpasswc_should_hide_cart_checkout_button', 'ourpasswc_is_hidden_for_test_mode', 1 );

/**
 * Checks if the app secret and public key is empty.
 *
 * @param bool $should_hide Flag from filter to hide or not hide the PDP button.
 *
 * @return bool true if the app secret and public is empty, false otherwise
 */
function ourpasswc_is_app_key_empty( $should_hide ) {

	if ( ! $should_hide ) {

		if ( empty(ourpasswc_get_public_key()) && empty(ourpasswc_get_secret_key())) {
			$should_hide = true;
		}

		ourpasswc_log_info( 'OurPass buttons' . ( $should_hide ? '' : ' not' ) . ' hidden for no app key.' );
	}

	return $should_hide;
}
add_filter( 'ourpasswc_should_hide_pdp_checkout_button', 'ourpasswc_is_app_key_empty', 1 );
add_filter( 'ourpasswc_should_hide_cart_checkout_button', 'ourpasswc_is_app_key_empty', 1 );

/**
 * Checks if is supported currency.
 *
 * @param bool $should_hide Flag from filter to hide or not hide the PDP button.
 *
 * @return bool true if is supported currency, false otherwise
 */
function ourpasswc_should_hide_for_unsupported_country( $should_hide ) {

	if ( ! $should_hide ) {

		$currency = get_woocommerce_currency();

        $supportedCurrencies = array_map(function($value){
            return strtoupper($value);
		}, explode(',', OURPASSWC_SUPPORTED_CURRENCY));
        
		if(! in_array(strtoupper($currency), $supportedCurrencies)){
            $should_hide = true;
		}
		
		ourpasswc_log_info( 'OurPass buttons' . ( $should_hide ? '' : ' not' ) . ' hidden for unsupported currency.' );
	}

	return $should_hide;
}
add_filter( 'ourpasswc_should_hide_pdp_checkout_button', 'ourpasswc_should_hide_for_unsupported_country', 1 );
add_filter( 'ourpasswc_should_hide_cart_checkout_button', 'ourpasswc_should_hide_for_unsupported_country', 1 );

/**
 * Determine if the OurPass PDP button should be hidden for a specific product.
 *
 * @param bool       $should_hide Flag from filter to hide or not hide the PDP button.
 * @param WC_Product $product     The product to check.
 *
 * @return bool
 */
function ourpasswc_should_hide_pdp_button_for_product( $should_hide, $product ) {
	if ( ! $should_hide ) {
		$ourpasswc_hidden_products = ourpasswc_get_products_to_hide_buttons();

		if ( ! empty( $ourpasswc_hidden_products ) ) {
			$product_id = ! empty( $product ) ? $product->get_id() : 0;

			if ( ! empty( $product_id ) && in_array( $product_id, $ourpasswc_hidden_products, true ) ) {
				$should_hide = true;
			}

			ourpasswc_log_info( 'PDP button' . ( $should_hide ? '' : ' not' ) . ' hidden for selected product: ' . $product_id );
		}
	}

	return $should_hide;
}
add_filter( 'ourpasswc_should_hide_pdp_checkout_button', 'ourpasswc_should_hide_pdp_button_for_product', 2, 2 );

/**
 * Determine if the OurPass PDP button should be hidden for an unsupported product.
 *
 * @param bool       $should_hide Flag from filter to hide or not hide the PDP button.
 * @param WC_Product $product     The product to check.
 *
 * @return bool
 */
function ourpasswc_should_hide_pdp_button_for_unsupported_product( $should_hide, $product ) {

	if ( ! $should_hide ) {
		$product_id = method_exists( $product, 'get_id' ) ? $product->get_id() : 0;

		// If the product is not supported, we should hide the PDP checkout button.
		if ( ! ourpasswc_product_is_supported( $product_id ) ) {
			$should_hide = true;
		}

		ourpasswc_log_info( 'PDP button' . ( $should_hide ? '' : ' not' ) . ' hidden for unsupported product: ' . $product_id );
	}

	return $should_hide;
}
add_filter( 'ourpasswc_should_hide_pdp_checkout_button', 'ourpasswc_should_hide_pdp_button_for_unsupported_product', 3, 2 );

/**
 * Determine if the OurPass PDP button should be hidden for an out-of-stock product.
 * Don't show OurPass checkout on PDP if the product is out of stock or on backorder.
 *
 * @param bool       $should_hide Flag from filter to hide or not hide the PDP button.
 * @param WC_Product $product     The product to check.
 *
 * @return bool
 */
function ourpasswc_should_hide_pdp_button_for_out_of_stock_product( $should_hide, $product ) {

	if ( ! $should_hide ) {
		$stock_status = method_exists( $product, 'get_stock_status' ) ? $product->get_stock_status() : '';
		$product_id   = method_exists( $product, 'get_id' ) ? $product->get_id() : 0;

		if ( 'outofstock' === $stock_status ) {
			$should_hide = true;
		}

		ourpasswc_log_info( 'PDP button' . ( $should_hide ? '' : ' not' ) . ' hidden for out of stock product: ' . $product_id );
	}

	return $should_hide;
}
add_filter( 'ourpasswc_should_hide_pdp_checkout_button', 'ourpasswc_should_hide_pdp_button_for_out_of_stock_product', 4, 2 );

/**
 * Determine if the OurPass PDP button should be hidden for an external product (i.e. not purchased on this store).
 *
 * @param bool       $should_hide Flag from filter to hide or not hide the PDP button.
 * @param WC_Product $product     The product to check.
 *
 * @return bool
 */
function ourpasswc_should_hide_pdp_button_for_external_product( $should_hide, $product ) {

	if ( ! $should_hide ) {
		if ( is_a( $product, WC_Product_External::class ) ) {
			$should_hide = true;
		}

		$product_id = method_exists( $product, 'get_id' ) ? $product->get_id() : 0;

		ourpasswc_log_info( 'PDP button' . ( $should_hide ? '' : ' not' ) . ' hidden for external product: ' . $product_id );
	}

	return $should_hide;
}
add_filter( 'ourpasswc_should_hide_pdp_checkout_button', 'ourpasswc_should_hide_pdp_button_for_out_of_stock_product', 5, 2 );

/**
 * Determine if the OurPass cart button should be hidden for a specific product.
 *
 * @param bool $should_hide Flag from filter to hide or not hide the cart button.
 *
 * @return bool
 */
function ourpasswc_should_hide_cart_button_for_product( $should_hide ) {

	if ( ! $should_hide ) {
		$ourpasswc_hidden_products = ourpasswc_get_products_to_hide_buttons();
		$product_id             = 0;

		if ( ! empty( $ourpasswc_hidden_products ) && ! empty( WC()->cart ) ) {
			$cart = WC()->cart->get_cart();

			foreach ( $cart as $cart_item ) {
				$product_id = ! empty( $cart_item['product_id'] ) ? $cart_item['product_id'] : 0;

				if ( ! empty( $product_id ) && in_array( $product_id, $ourpasswc_hidden_products, true ) ) {
					$should_hide = true;
					break;
				}
			}
		}

		ourpasswc_log_info( 'Cart button' . ( $should_hide ? '' : ' not' ) . ' hidden for selected product: ' . $product_id );
	}

	return $should_hide;
}
add_filter( 'ourpasswc_should_hide_cart_checkout_button', 'ourpasswc_should_hide_cart_button_for_product', 2 );

/**
 * Check cart for products we don't support.
 *
 * @param bool $should_hide Flag from filter to hide or not hide the cart button.
 *
 * @return bool
 */
function ourpasswc_should_hide_cart_button_because_unsupported_products( $should_hide ) {

	if ( ! $should_hide ) {
		$cart = WC()->cart;

		$cart_items          = method_exists( $cart, 'get_cart' ) ? $cart->get_cart() : array();
		$unsupported_product = 0;

		if ( empty( $cart_items ) ) {
			$should_hide = true;
		} else {
			// Check for products we don't support.
			foreach ( $cart_items as $cart_item ) {
				if ( ! ourpasswc_product_is_supported( $cart_item['product_id'] ) ) {
					$should_hide         = true;
					$unsupported_product = $cart_item['product_id'];
					break;
				}

				if (
					! empty( $cart_item['wcsatt_data'] ) &&
					! empty( $cart_item['wcsatt_data']['active_subscription_scheme'] )
				) {
					// If the store is using "WooCommerce All Products For Subscriptions" plugin, then this field might be set.
					// If it is anything other than false, then this is a product that has been converted to a subcription; hide the
					// button.
					$should_hide         = true;
					$unsupported_product = $cart_item['product_id'];
					break;
				}
			}
		}

		ourpasswc_log_info( 'Cart button' . ( $should_hide ? '' : ' not' ) . ' hidden for unsupported product' . ( ! empty( $unsupported_product ) ? ': ' . $unsupported_product : '.' ) );
	}

	return $should_hide;
}
add_filter( 'ourpasswc_should_hide_cart_checkout_button', 'ourpasswc_should_hide_cart_button_because_unsupported_products', 2 );
