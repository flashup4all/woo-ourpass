<?php

/**
 * OurPass admin settings footer.
 *
 * @package OurPass
 */

$ourpasswc_setting_ourpass_onboarding_url = OURPASSWC_ONBOARDING_URL;
?>

<div class="ourpass-footer">
	<ul class="ourpass-footer-links">
		<li class="ourpass-footer-link">
			<a href="https://wordpress.org/plugins/ourpass-payment-gateway" target="_blank" rel="noopener">
				<strong><?php esc_html_e('OurPass Checkout for WooCommerce'); ?></strong>
			</a>
		</li>
		<li class="ourpass-footer-link alignright">
			<a href="https://wordpress.org/plugins/ourpass-payment-gateway" target="_blank" rel="noopener">
				<?php
				printf(
					'%1$s %2$s',
					esc_html__('Version'),
					esc_html(OURPASSWC_VERSION)
				);
				?>
			</a>
		</li>
		<li class="ourpass-footer-link">
			<a href="<?php echo esc_url($ourpasswc_setting_ourpass_onboarding_url); ?>" target="_blank" rel="noopener" title="<?php esc_attr_e('Login to the OurPass Merchant Dashboard'); ?>">
				<?php esc_html_e('Merchant Login'); ?>
			</a>
		</li>
		<li class="ourpass-footer-link">
			<a href="https://ourpass.co/about" target="_blank" rel="noopener" title="<?php esc_attr_e('Learn more about OurPass'); ?>">
				<?php esc_html_e('About'); ?>
			</a>
		</li>
		<li class="ourpass-footer-link">
			<a href="https://ourpass.co/blog" target="_blank" rel="noopener">
				<?php esc_html_e('Blog'); ?>
			</a>
		</li>
		<li class="ourpass-footer-link">
			<a href="https://ourpass.co/terms-of-service" target="_blank" rel="noopener">
				<?php esc_html_e('Terms'); ?>
			</a>
		</li>
		<li class="ourpass-footer-link">
			<a href="https://ourpass.co/privacy-policy" target="_blank" rel="noopener">
				<?php esc_html_e('Privacy'); ?>
			</a>
		</li>
	</ul>
</div>