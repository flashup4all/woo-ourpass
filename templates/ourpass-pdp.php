<?php
/**
 * OurPass PDP checkout template.
 *
 * @package OurPass
 */

$ourpasswc_pdp_button_hook = ourpasswc_get_pdp_button_hook();
?>

<div class="ourpass-pdp-wrapper <?php echo esc_attr( $ourpasswc_pdp_button_hook ); ?>">
	<?php if ( 'woocommerce_after_add_to_cart_button' === $ourpasswc_pdp_button_hook ) : ?>
	<div class="ourpass-pdp-or"><?php esc_html_e( 'OR'); ?></div>
	<?php endif; ?>

	<?php ourpasswc_load_template( 'buttons/ourpass-checkout-button' ); ?>
	
	<?php if ( 'woocommerce_after_add_to_cart_button' !== $ourpasswc_pdp_button_hook ) : ?>
	<div class="ourpass-pdp-or"><?php esc_html_e( 'OR'); ?></div>
	<?php endif; ?>
</div>
