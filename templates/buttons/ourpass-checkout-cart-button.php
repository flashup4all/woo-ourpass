<?php
/**
 * Fast checkout cart button template.
 *
 * @package Fast
 */

$ourpasswc_app_id         = ourpasswc_get_secret_key();
$ourpasswc_cart_data      = ourpasswc_get_cart_data();
$cart_data             = wp_json_encode( array_values( $ourpasswc_cart_data ) );
$applied_coupons       = ! empty( WC()->cart ) ? WC()->cart->get_applied_coupons() : array();
$applied_coupons_count = count( $applied_coupons );

?>

<button
		app_id="<?php echo esc_attr( $ourpasswc_app_id ); ?>"
		cart_data="<?php echo esc_attr( $cart_data ); ?>"
		<?php
		if ( 1 === $applied_coupons_count ) {
			?>
				coupon_code="<?php echo esc_attr( $applied_coupons[0] ); ?>"
				<?php
		}
		?>
	> CHECKOUT WITH OURPASS </button>