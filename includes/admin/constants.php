<?php
/**
 * Fast Plugin Settings Constants
 *
 * @package Fast
 */

define('OURPASSWC_ENVIRONMENT', 'sandbox');
define('OURPASSWC_SETTINGS_TIMESTAMPS', 'ourpasswc_settings_timestamps');
// APP INFO SETTINGS
define( 'OURPASSWC_SETTING_DEBUG_MODE', 'ourpasswc_debug_mode' );
define( 'OURPASSWC_SETTING_DEBUG_MODE_NOT_SET', 'ourpass debug mode not set' );
define( 'OURPASSWC_SETTING_TEST_MODE', 'ourpasswc_test_mode' );
define( 'OURPASSWC_SETTING_TEST_MODE_NOT_SET', 'ourpass test mode not set' );
define('OURPASSWC_SETTING_TEST_PUBLIC_KEY', 'ourpasswc_test_public_key');
define('OURPASSWC_SETTING_TEST_SECRET_KEY', 'ourpasswc_test_secret_key');
define('OURPASSWC_SETTING_LIVE_PUBLIC_KEY', 'ourpasswc_live_public_key');
define('OURPASSWC_SETTING_LIVE_SECRET_KEY', 'ourpasswc_live_secret_key');
//APP OPTION SETTING
define('OURPASSWC_SETTING_PDP_BUTTON_HOOK', 'ourpass_pdp_button_hook');
define('OURPASSWC_DEFAULT_PDP_BUTTON_HOOK', 'woocommerce_after_add_to_cart_quantity');
define('OURPASSWC_SETTING_HIDE_BUTTON_PRODUCTS', 'ourpass_hide_button_products');
define('OURPASSWC_SETTING_CHECKOUT_REDIRECT_PAGE', 'ourpasswc_checkout_redirect_page');
// OTHER SETTINGS
define('OURPASSWC_SETTING_ONBOARDING_URL', 'ourpasswc_onboarding_url');
define('OURPASSWC_ONBOARDING_URL', 'https://merchant.ourpass.co');
define('OURPASSWC_SUPPORTED_CURRENCY', 'NGN');


define( 'OURPASSWC_SETTING_LOAD_BUTTON_STYLES', 'ourpasswc_load_button_styles' );
define( 'OURPASSWC_SETTING_LOAD_BUTTON_STYLES_NOT_SET', 'ourpass load button styles not set' );
define( 'OURPASSWC_SETTING_PDP_BUTTON_STYLES', 'ourpass_pdp_button_styles' );
define( 'OURPASSWC_SETTING_CART_BUTTON_STYLES', 'ourpass_cart_button_styles' );
define( 'OURPASSWC_SETTING_MINI_CART_BUTTON_STYLES', 'ourpass_mini_cart_button_styles' );
define( 'OURPASSWC_SETTING_CHECKOUT_BUTTON_STYLES', 'ourpass_checkout_button_styles' );

define('OURPASSWC_SETTING_USE_DARK_MODE', 'ourpasswc_use_dark_mode');
define('OURPASSWC_SETTING_DISABLE_MULTICURRENCY', 'ourpasswc_disable_multicurrency');
define( 'OURPASSWC_SETTING_PDP_BUTTON_HOOK_OTHER', 'ourpass_pdp_button_hook_other' );
define( 'OURPASSWC_SETTING_PLUGIN_DO_INIT_FORMAT', 'ourpasswc_do_init_%s' );



define('OURPASSWC_SETTING_SHOW_LOGIN_BUTTON_FOOTER', 'ourpasswc_show_login_button_footer');
define('OURPASSWC_SETTING_LOGIN_FOOTER_NOT_SET', 'ourpass login in footer not set');



define('OURPASSWC_SETTING_FAST_JS_URL', 'fast_fast_js_url');
define( 'OURPASSWC_JS_URL', 'https://js.fast.co/fast-woocommerce.js' );

define('OURPASSWC_SETTING_FAST_JWKS_URL', 'fast_fast_jwks_url');
define( 'OURPASSWC_JWKS_URL', 'https://api.fast.co/v1/oauth2/jwks' );


define(
	'OURPASSWC_SETTING_PDP_BUTTON_STYLES_DEFAULT',
	<<<CSS
.ourpass-pdp-wrapper {
  padding: 21px 0 20px 0;
  margin: 20px 0;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
}

.ourpass-pdp-or {
  position: relative;
  top: 21px;
  width: 40px;
  height: 1px;
  line-height: 0;
  text-align: center;
  margin-left: auto;
  margin-right: auto;
  color: #757575;
  background: white;
}

.woocommerce_after_add_to_cart_button .ourpass-pdp-or {
  top: -22px;
}

@media only screen and (max-width: 767px) {
  .ourpass-pdp-wrapper {
    border-bottom: 1px solid #dfdfdf;
    border-radius: none;
    padding-right: 1%;
    padding-left: 1%;
  }
}

@media only screen and (min-width: 768px) {
  .ourpass-pdp-wrapper {
    border: 1px solid #dfdfdf;
    border-radius: 5px;
    padding-right: 10%;
    padding-left: 10%;
  }
}
CSS
);

define(
	'OURPASSWC_SETTING_CART_BUTTON_STYLES_DEFAULT',
	<<<CSS
.ourpass-cart-wrapper {
  padding: 21px 0 20px 0;
  margin-bottom: 20px;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
}

.ourpass-cart-or {
  position: relative;
  top: 21px;
  width: 40px;
  height: 1px;
  line-height: 0;
  text-align: center;
  margin-left: auto;
  margin-right: auto;
  color: #757575;
  background: white;
}

@media only screen and (max-width: 767px) {
  .ourpass-cart-wrapper {
    border-bottom: 1px solid #dfdfdf;
    border-radius: none;
    padding-right: 1%;
    padding-left: 1%;
  }
}

@media only screen and (min-width: 768px) {
  .ourpass-cart-wrapper {
    border: 1px solid #dfdfdf;
    border-radius: 5px;
    padding-right: 10%;
    padding-left: 10%;
  }
}
CSS
);

define(
	'OURPASSWC_SETTING_MINI_CART_BUTTON_STYLES_DEFAULT',
	<<<CSS
.ourpass-mini-cart-wrapper {
  height: 68px;
  clear: both;
  border-bottom: 1px solid #dfdfdf;
  padding-bottom: 0px;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
}

.ourpass-mini-cart-or {
  position: relative;
  background: inherit;
  width: 40px;
  text-align: center;
  margin-left: auto;
  margin-right: auto;
  color: #dfdfdf;
}
CSS
);

define(
	'OURPASSWC_SETTING_CHECKOUT_BUTTON_STYLES_DEFAULT',
	<<<CSS
.ourpass-checkout-wrapper {
  padding: 21px 0 20px 0;
  margin-bottom: 20px;
}

.ourpass-checkout-or {
  position: relative;
  top: 21px;
  width: 40px;
  height: 1px;
  line-height: 0;
  text-align: center;
  margin-left: auto;
  margin-right: auto;
  color: #757575;
  background: white;
}

@media only screen and (max-width: 767px) {
  .ourpass-checkout-wrapper {
    border-bottom: 1px solid #dfdfdf;
    border-radius: none;
    padding-right: 1%;
    padding-left: 1%;
  }
}

@media only screen and (min-width: 768px) {
  .ourpass-checkout-wrapper {
    border: 1px solid #dfdfdf;
    border-radius: 5px;
    padding-right: 10%;
    padding-left: 10%;
  }
}
CSS
);
