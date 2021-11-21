<?php
/**
 * OurPass cart checkout template.
 *
 * @package OurPass
 */

?>

		<div class="ourpass-cart-wrapper">
			<?php ourpasswc_load_template( 'buttons/ourpass-checkout-cart-button' ); ?>
			<div class="ourpass-cart-or"><?php esc_html_e( 'OR'); ?></div>
		</div>
