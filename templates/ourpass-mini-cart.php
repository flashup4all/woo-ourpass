<?php
/**
 * OurPass mini cart checkout template.
 *
 * @package OurPass
 */

?>

		<div class="ourpass-mini-cart-wrapper">
			<?php ourpasswc_load_template( 'buttons/ourpass-checkout-cart-button' ); ?>
			<div class="ourpass-mini-cart-or"><?php esc_html_e( 'OR'); ?></div>
		</div>
