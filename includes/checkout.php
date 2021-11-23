<?php
/**
 * OurPass Checkout
 *
 * Adds OurPass Checkout button to store.
 *
 * @package OurPass
 */

// Load helpers to check if/when to hide the OurPass Checkout buttons.
require_once OURPASSWC_PATH . 'includes/hide.php';

/**
 * Returns cart item data that OurPass Checkout button can interpret.
 * This function also populates some global variables about cart state, such as whether it contains products we don't support.
 */
function ourpasswc_get_cart_data() {
	$ourpasswc_cart_data = array();

	if ( ! empty( WC()->cart ) ) {
		foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
			// Populate info about this cart item.
			// OurPass backend expects strings for product/variant/quantity so we use strval() here.
			$ourpasswc_cart_item_data = array(
				'product_id' => strval( $cart_item['product_id'] ),
				'quantity'   => strval( intval( $cart_item['quantity'] ) ), // quantity is a float in wc, casting to int first to be safer.
			);
			if ( ! empty( $cart_item['variation_id'] ) ) {
				// Only track variation_id if it's set.
				$ourpasswc_cart_item_data['variant_id'] = strval( $cart_item['variation_id'] );
			}
			if ( ! empty( $cart_item['variation'] ) ) {
				// Track the attribute options if they are set.
				foreach ( $cart_item['variation'] as $option_id => $option_value ) {
					$ourpasswc_cart_item_data['option_values'][] = array(
						'option_id'    => $option_id,
						'option_value' => $option_value,
					);
				}
			}
			$ourpasswc_cart_data[ $cart_item_key ] = $ourpasswc_cart_item_data;
		}

		ourpasswc_log_debug( 'Fetched cart data: ' . print_r( $ourpasswc_cart_data, true ) ); // phpcs:ignore
	}

	return $ourpasswc_cart_data;
}

/**
 * Maybe render the OurPass Checkout button.
 *
 * @param string $button_type The type of button to maybe render.
 * @param string $template    The template to use.
 */
function ourpasswc_maybe_render_checkout_button( $button_type, $template ) {
	$button_types = array( 'pdp', 'cart' );

	if (
		! in_array( $button_type, $button_types, true ) ||
		( 'pdp' === $button_type && ourpasswc_should_hide_pdp_checkout_button() ) ||
		( 'cart' === $button_type && ourpasswc_should_hide_cart_checkout_button() )
	) {
		ourpasswc_log_info( 'Not rendering checkout button. Type: ' . $button_type . ', Template: ' . $template );
		return;
	}

	ourpasswc_load_template( $template );
}

/**
 * Maybe render the PDP checkout button.
 */
function ourpasswc_maybe_render_pdp_button() {
	$current_hook           = current_action();
	$ourpasswc_pdp_button_hook = ourpasswc_get_pdp_button_hook();

	if ( $current_hook === $ourpasswc_pdp_button_hook ) {
		ourpasswc_maybe_render_checkout_button( 'pdp', 'ourpass-pdp' );
	}
}

/**
 * Inject OurPass Checkout button at the selected hook.
 */
function ourpasswc_pdp_button_hook_init() {
	$ourpasswc_pdp_button_hook = ourpasswc_get_pdp_button_hook();

	add_action( $ourpasswc_pdp_button_hook, 'ourpasswc_maybe_render_pdp_button' );
}
add_action( 'init', 'ourpasswc_pdp_button_hook_init' );

/**
 * Inject OurPass Checkout button after Proceed to Checkout button on cart page.
 */
function ourpasswc_woocommerce_proceed_to_checkout() {
	ourpasswc_maybe_render_checkout_button( 'cart', 'ourpass-cart' );
}
add_action( 'woocommerce_proceed_to_checkout', 'ourpasswc_woocommerce_proceed_to_checkout', 9 );

/**
 * Inject the OurPass Checkout button on the mini-cart widget.
 */
function ourpasswc_woocommerce_widget_shopping_cart_before_buttons() {
	ourpasswc_maybe_render_checkout_button( 'cart', 'ourpass-mini-cart' );
}
add_action( 'woocommerce_widget_shopping_cart_before_buttons', 'ourpasswc_woocommerce_widget_shopping_cart_before_buttons', 30 );

/**
 * Inject the OurPass Checkout button on the checkout page.
 */
function ourpasswc_woocommerce_before_checkout_form() {
	ourpasswc_maybe_render_checkout_button( 'cart', 'ourpass-checkout' );
}
add_action( 'woocommerce_before_checkout_form', 'ourpasswc_woocommerce_before_checkout_form' );

/**
 * Clear the cart of `ourpass_order_created=1` is added to the URL.
 */
function ourpasswc_maybe_clear_cart_and_redirect() {
	$ourpass_order_created = isset( $_GET['ourpass_order_created'] ) ? absint( $_GET['ourpass_order_created'] ) : false; // phpcs:ignore

	if (
		1 === $ourpass_order_created &&
		! empty( WC()->cart ) &&
		is_callable( array( WC()->cart, 'empty_cart' ) )
	) {
		ourpasswc_log_info( 'Clearing cart and redirecting after order created.' );
		WC()->cart->empty_cart();

		$redirect_page = absint( get_option( OURPASSWC_SETTING_CHECKOUT_REDIRECT_PAGE, 0 ) );
		$redirect_url  = wc_get_cart_url();

		if ( ! empty( $redirect_page ) ) {
			$redirect_page_url = get_permalink( $redirect_page );

			// Only change the redirect URL if the redirect page URL is valid.
			$redirect_url = ! empty( $redirect_page_url ) ? $redirect_page_url : $redirect_url;
		}

		wp_safe_redirect( $redirect_url );
	}
}
add_action( 'init', 'ourpasswc_maybe_clear_cart_and_redirect' );
