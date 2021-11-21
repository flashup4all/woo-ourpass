<?php
/**
 * Fast checkout button template.
 *
 * @package Fast
 */
// global $product;
$ourpasswc_api_key         = ourpasswc_get_secret_key();
$product_id            = ! empty( $args['product_id'] ) ? absint( $args['product_id'] ) : 0;
$variant_id            = ! empty( $args['variant_id'] ) ? absint( $args['variant_id'] ) : 0;
$quantity              = ! empty( $args['quantity'] ) ? absint( $args['quantity'] ) : 0;
$product_options       = ! empty( $args['product_options'] ) ? ourpasswc_get_normalized_product_options( $args['product_options'] ) : '';
$ourpasswc_use_dark_mode  = ourpasswc_use_dark_mode( $product_id );

?>

<ourpass-product-checkout-button
	api_key="<?php echo esc_attr( $ourpasswc_api_key ); ?>"

	<?php if ( ! empty( $product_id ) ) : ?>
		product_id="<?php echo esc_attr( $product_id ); ?>"
		<?php if ( ! empty( $variant_id ) ) : ?>
			variant_id="<?php echo esc_attr( $variant_id ); ?>"
		<?php endif; ?>

		<?php if ( ! empty( $quantity ) ) : ?>
			quantity="<?php echo esc_attr( $quantity ); ?>"
		<?php endif; ?>

		<?php if ( ! empty( $product_options ) ) : ?>
			product_options="<?php echo esc_attr( $product_options ); ?>"
		<?php endif; ?>
	<?php endif; ?>

	<?php if ( $ourpasswc_use_dark_mode ) : ?> dark <?php endif; ?>
		
></ourpass-product-checkout-button>

