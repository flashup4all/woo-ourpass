<?php
/**
 * Fast Plugin Settings Constants
 *
 * @package Fast
 */

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







define( 'OURPASSWC_SETTING_LOAD_BUTTON_STYLES', 'fastwc_load_button_styles' );
define( 'OURPASSWC_SETTING_LOAD_BUTTON_STYLES_NOT_SET', 'fast load button styles not set' );
define( 'OURPASSWC_SETTING_PDP_BUTTON_STYLES', 'fast_pdp_button_styles' );
define( 'OURPASSWC_SETTING_CART_BUTTON_STYLES', 'fast_cart_button_styles' );
define( 'OURPASSWC_SETTING_MINI_CART_BUTTON_STYLES', 'fast_mini_cart_button_styles' );
define( 'OURPASSWC_SETTING_CHECKOUT_BUTTON_STYLES', 'fast_checkout_button_styles' );
define( 'OURPASSWC_SETTING_LOGIN_BUTTON_STYLES', 'fast_login_button_styles' );

define( 'OURPASSWC_SETTING_SHOW_LOGIN_BUTTON_FOOTER', 'fastwc_show_login_button_footer' );
define( 'OURPASSWC_SETTING_LOGIN_FOOTER_NOT_SET', 'fast login in footer not set' );

define('OURPASSWC_SETTING_USE_DARK_MODE', 'ourpasswc_use_dark_mode');
define('OURPASSWC_SETTING_DISABLE_MULTICURRENCY', 'ourpasswc_disable_multicurrency');

define( 'OURPASSWC_SETTING_PDP_BUTTON_HOOK_OTHER', 'fast_pdp_button_hook_other' );

define( 'OURPASSWC_SETTING_PLUGIN_DO_INIT_FORMAT', 'fastwc_do_init_%s' );






define('OURPASSWC_SETTING_FAST_JS_URL', 'fast_fast_js_url');
define( 'OURPASSWC_JS_URL', 'https://js.fast.co/fast-woocommerce.js' );

define('OURPASSWC_SETTING_FAST_JWKS_URL', 'fast_fast_jwks_url');
define( 'OURPASSWC_JWKS_URL', 'https://api.fast.co/v1/oauth2/jwks' );


define(
	'OURPASSWC_SETTING_PDP_BUTTON_STYLES_DEFAULT',
	<<<CSS
.fast-pdp-wrapper {
  padding: 21px 0 20px 0;
  margin: 20px 0;
}

.fast-pdp-or {
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

.woocommerce_after_add_to_cart_button .fast-pdp-or {
  top: -22px;
}

@media only screen and (max-width: 767px) {
  .fast-pdp-wrapper {
    border-bottom: 1px solid #dfdfdf;
    border-radius: none;
    padding-right: 1%;
    padding-left: 1%;
  }
}

@media only screen and (min-width: 768px) {
  .fast-pdp-wrapper {
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
.fast-cart-wrapper {
  padding: 21px 0 20px 0;
  margin-bottom: 20px;
}

.fast-cart-or {
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
  .fast-cart-wrapper {
    border-bottom: 1px solid #dfdfdf;
    border-radius: none;
    padding-right: 1%;
    padding-left: 1%;
  }
}

@media only screen and (min-width: 768px) {
  .fast-cart-wrapper {
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
.fast-mini-cart-wrapper {
  height: 68px;
  clear: both;
  border-bottom: 1px solid #dfdfdf;
  padding-bottom: 0px;
}

.fast-mini-cart-or {
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
.fast-checkout-wrapper {
  padding: 21px 0 20px 0;
  margin-bottom: 20px;
}

.fast-checkout-or {
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
  .fast-checkout-wrapper {
    border-bottom: 1px solid #dfdfdf;
    border-radius: none;
    padding-right: 1%;
    padding-left: 1%;
  }
}

@media only screen and (min-width: 768px) {
  .fast-checkout-wrapper {
    border: 1px solid #dfdfdf;
    border-radius: 5px;
    padding-right: 10%;
    padding-left: 10%;
  }
}
CSS
);

define(
	'OURPASSWC_SETTING_LOGIN_BUTTON_STYLES_DEFAULT',
	<<<CSS
.fast-login-wrapper {
  border: 1.25px solid #d3ced2;
  padding: 16px 30% 16px 30%;
  margin-left: 16px;
  margin-right: 16px;
}

@media (min-width: 560px) {
  .fast-login-wrapper {
    width: 100%;
    padding: 16px 30% 16px 30%;
    margin-left: auto;
    margin-right: auto;
  }
}

@media (min-width: 1006px) {
  .fast-login-wrapper {
    width: 1006px;
    padding: 16px 300px 16px 300px;
  }
}
CSS
);
