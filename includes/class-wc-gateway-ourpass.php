<?php

if (!defined('ABSPATH')) {
    exit;
}

class WC_Gateway_Ourpass extends WC_Payment_Gateway
{

    public function __construct()
    {
        $this->id                       = 'ourpass';
        $this->method_title             = 'Ourpass';
        $this->method_description       = sprintf('Ourpass provide merchants with the tools and services needed to accept online payments from customers. <a href="%1$s" target="_blank">Sign up</a> for a Ourpass account, and <a href="%2$s" target="_blank">get your API keys</a>.', 'https://ourpass.co', 'https://merchant.ourpass.co/settings');
        $this->has_fields               = false;
        $this->order_button_text        = 'Make Payment';
        $this->ourpass_environment_is_production      = true;
        $this->ourpass_production_base_url    = 'https://beta-api.ourpass.co';
        $this->ourpass_staging_base_url    = 'https://user-api-staging.ourpass.co';

        // Load the form fields.
        $this->init_form_fields();

        // Load the settings.
        $this->init_settings();

        // Get setting values
        $this->enabled            = $this->get_option('enabled');
        $this->title              = $this->get_option('title');
        $this->description        = $this->get_option('description');
        $this->testmode           = $this->get_option('testmode') === 'yes' ? true : false;
        $this->autocomplete_order = $this->get_option('autocomplete_order') === 'yes' ? true : false;


        $this->test_public_key = $this->get_option('test_public_key');
        $this->test_secret_key = $this->get_option('test_secret_key');

        $this->live_public_key = $this->get_option('live_public_key');
        $this->live_secret_key = $this->get_option('live_secret_key');

        $this->public_key = $this->testmode ? $this->test_public_key : $this->live_public_key;
        $this->secret_key = $this->testmode ? $this->test_secret_key : $this->live_secret_key;
        $this->ourpass_base_url = $this->ourpass_environment_is_production 
            ? $this->ourpass_production_base_url 
            : $this->ourpass_staging_base_url ;
        

        // Hooks
        add_action('wp_enqueue_scripts', array($this, 'payment_scripts'));
        add_action('admin_enqueue_scripts', array($this, 'admin_scripts'));
        add_action('admin_notices', array($this, 'admin_notices'));

        add_action('woocommerce_update_options_payment_gateways_' . $this->id, array($this, 'process_admin_options'));


        add_action('woocommerce_receipt_' . $this->id, array($this, 'receipt_page'));

        // Payment callback handler
        add_action('woocommerce_api_wc_gateway_ourpass', array($this, 'verify_ourpass_transaction'));

        // Check if the gateway can be used
        if (!$this->is_valid_for_use()) {
            $this->enabled = false;
        }
    }

    /**
     * Check if this gateway is enabled and available in the user's country.
     */
    public function is_valid_for_use()
    {
        $allowedCurrencies = array(
            'NGN' => '&#8358;'
        );

        if (!in_array(get_woocommerce_currency(), apply_filters('woocommerce_ourpass_supported_currencies', array_keys($allowedCurrencies)))) {

            $this->msg = sprintf('Ourpass does not support your store currency. Kindly set it to either NGN (&#8358;) <a href="%s">here</a>', admin_url('admin.php?page=wc-settings&tab=general'));

            return false;
        }

        return true;
    }

    /**
     * Display ourpass payment icon.
     */
    public function get_icon()
    {
        $base_location = wc_get_base_location();

        $icon = '<img src="' . WC_HTTPS::force_https_url(plugins_url('assets/images/ourpass-wc.svg', WC_OURPASS_MAIN_FILE)) . '" alt="Ourpass Payment Options" />';

        return apply_filters('woocommerce_gateway_icon', $icon, $this->id);
    }

    /**
     * Check if ourpass merchant details is filled.
     */
    public function admin_notices()
    {
        if ($this->enabled == 'no') {
            return;
        }

        // Check required fields.
        if (!($this->public_key && $this->secret_key)) {
            echo '<div class="error"><p>' . sprintf('Please enter your Ourpass merchant details <a href="%s">here</a> to be able to use the Ourpass WooCommerce plugin.', admin_url('admin.php?page=wc-settings&tab=checkout&section=ourpass')) . '</p></div>';
            return;
        }
    }

    /**
     * Check if Ourpass gateway is enabled.
     *
     * @return bool
     */
    public function is_available()
    {

        if ('yes' == $this->enabled) {

            if (!($this->public_key && $this->secret_key)) {

                return false;
            }

            return true;
        }

        return false;
    }

    /**
     * Admin Panel Options.
     */
    public function admin_options()
    {
        ?>

        <h2>
            <?php echo 'Ourpass'; ?>
            <?php
            if (function_exists('wc_back_link')) {
                wc_back_link('Return to payments', admin_url('admin.php?page=wc-settings&tab=checkout'));
            }
            ?>
        </h2>

        <?php
        if ($this->is_valid_for_use()) {
            echo '<table class="form-table">';
            $this->generate_settings_html();
            echo '</table>';
        } else {
        ?>
            <div class="inline error">
                <p><strong><?php echo 'Ourpass Payment Gateway Disabled'; ?></strong>: <?php echo $this->msg; ?></p>
            </div>

            <?php
        }
    }

    /**
     * Initialize Gateway Settings Form Fields.
     */
    public function init_form_fields()
    {
        $form_fields = array(
            'enabled' => array(
                'title'       => 'Enable/Disable',
                'label'       => 'Enable Ourpass',
                'type'        => 'checkbox',
                'description' => 'Enable Ourpass as a payment option on the checkout page.',
                'default'     => 'no',
                'desc_tip'    => true,
            ),
            'title' => array(
                'title'       => 'Title',
                'type'        => 'text',
                'description' => 'This controls the payment method title which the user sees during checkout.',
                'default'     => 'Ourpass',
                'desc_tip'    => true,
            ),
            'description' => array(
                'title'       => 'Description',
                'type'        => 'textarea',
                'description' => 'This controls the payment method description which the user sees during checkout.',
                'default'     => 'Make payment using your ourpass wallet',
                'desc_tip'    => true,
            ),
            'testmode' => array(
                'title'       => 'Test mode',
                'label'       => 'Enable Test Mode',
                'type'        => 'checkbox',
                'description' => 'Test mode enables you to test payments before going live. <br />Once the LIVE MODE is enabled on your Ourpass account uncheck this.',
                'default'     => 'yes',
                'desc_tip'    => true,
            ),
            'test_secret_key' => array(
                'title'       => 'Test Secret Key',
                'type'        => 'text',
                'description' => 'Enter your Test Secret Key here',
                'default'     => '',
            ),
            'test_public_key' => array(
                'title'       => 'Test Public Key',
                'type'        => 'text',
                'description' => 'Enter your Test Public Key here.',
                'default'     => '',
            ),
            'live_secret_key' => array(
                'title'       => 'Live Secret Key',
                'type'        => 'text',
                'description' => 'Enter your Live Secret Key here.',
                'default'     => '',
            ),
            'live_public_key' => array(
                'title'       => 'Live Public Key',
                'type'        => 'text',
                'description' => 'Enter your Live Public Key here.',
                'default'     => '',
            ),
            'autocomplete_order' => array(
                'title'       => 'Autocomplete Order After Payment',
                'label'       => 'Autocomplete Order',
                'type'        => 'checkbox',
                'class'       => 'wc-ourpass-autocomplete-order',
                'description' => 'If enabled, the order will be marked as complete after successful payment',
                'default'     => 'no',
                'desc_tip'    => true,
            ),
        );

        $this->form_fields = $form_fields;
    }

    /**
     * Outputs scripts used for ourpass payment.
     */
    public function payment_scripts()
    {
        if (!is_checkout_pay_page()) {
            return;
        }

        if ($this->enabled === 'no') {
            return;
        }

        $order_key = urldecode($_GET['key']);
        $order_id  = absint(get_query_var('order-pay'));

        $order = wc_get_order($order_id);

        $payment_method = method_exists($order, 'get_payment_method') ? $order->get_payment_method() : $order->payment_method;

        if ($this->id !== $payment_method) {
            return;
        }

        $suffix = (defined('SCRIPT_DEBUG') && SCRIPT_DEBUG) ? '' : '.min';

        wp_enqueue_script('jquery');

        wp_enqueue_script('ourpass', plugins_url('assets/js/cdn' . $suffix . '.js', WC_OURPASS_MAIN_FILE), array('jquery'), WC_OURPASS_VERSION, true);
        wp_enqueue_script('wc_ourpass', plugins_url('assets/js/ourpass' . $suffix . '.js', WC_OURPASS_MAIN_FILE), array('jquery', 'ourpass'), WC_OURPASS_VERSION, true);

        $ourpass_params = array(
            'env' => $this->ourpass_environment_is_production ? 'production' : 'sandbox',
            'api_key' => $this->secret_key,
        );

        if (is_checkout_pay_page() && get_query_var('order-pay')) {

            if (in_array($order->get_status(), array('processing', 'on-hold', 'completed'))) {
                wp_redirect($this->get_return_url($order));
                exit;
            }

            $ourpass_params['amount'] = $order->get_total();
            $ourpass_params['reference'] = 'WC_ORDER_'.$order_id . '_' . time();
            $ourpass_params['email'] = '';
            $ourpass_params['qty'] = 1;

            //Getting the items;
            $items = [];

            foreach ($order->get_items() as $key => $lineItem) 
            {
                $product_id = $lineItem['product_id'];
                $product = wc_get_product( $product_id );

                $description = ($product->get_short_description() !== '') 
                    ? $product->get_short_description()
                    : substr($product->get_description(), 0, 20) . '...';

                $productInfo = [
                    'name' =>  $lineItem['name'],
                    'src' => wp_get_attachment_image_url($product->get_image_id(), 'full'),
                    'amount' => $lineItem['total'],
                    'url' => preg_replace("#^[^:/.]*[:/]+#i", "", urldecode(get_permalink($product_id))),
                    'qty' => $lineItem['qty'],
                    'description' => $description,
                    'email' => ''
                ];

                $items[] = $productInfo;
            }

            $ourpass_params['items'] = $items;

            if($ourpass_params['items'][0]) {
                $ourpass_params['name'] = $ourpass_params['items'][0]['name'];
                $ourpass_params['description'] = $ourpass_params['items'][0]['description'];
                $ourpass_params['src'] = $ourpass_params['items'][0]['src'];
                $ourpass_params['url'] = $ourpass_params['items'][0]['url'];
            }

            update_post_meta($order_id, '_ourpass_reference', $ourpass_params['reference']);
        }

        wp_localize_script('wc_ourpass', 'wc_ourpass_params', $ourpass_params);
    }

    /**
     * Load admin scripts.
     */
    public function admin_scripts()
    {
        if ('woocommerce_page_wc-settings' !== get_current_screen()->id) {
            return;
        }

        $suffix = defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ? '' : '.min';

        $ourpass_admin_params = array(
            'plugin_url' => WC_OURPASS_URL,
        );

        wp_enqueue_script('wc_ourpass_admin', plugins_url('assets/js/ourpass-admin' . $suffix . '.js', WC_OURPASS_MAIN_FILE), array(), WC_OURPASS_VERSION, true);

        wp_localize_script('wc_ourpass_admin', 'wc_ourpass_admin_params', $ourpass_admin_params);
    }

    /**
     * Process the payment.
     *
     * @param int $order_id
     *
     * @return array|void
     */
    public function process_payment($order_id)
    {
        $order = wc_get_order($order_id);

        return array(
            'result'   => 'success',
            'redirect' => $order->get_checkout_payment_url(true),
        );
    }

    /**
     * Displays the payment page.
     * The form that show on the order-pay page
     *
     * @param $order_id
     */
    public function receipt_page($order_id)
    {

        $order = wc_get_order($order_id);

        $html = "";
        $html .= '<div id="wc-ourpass-form">';
        $html .= '<p>' . 'Thank you for your order, please click the button below to pay with Ourpass.' . '</p>';
        $html .= '<div id="ourpass_form"><form id="order_review" method="post" action="' . WC()->api_request_url('WC_Gateway_Ourpass') . '"></form>';
        $html .= '<div id="ourpass-button-container">';
        $html .= '<button class="button" id="ourpass-payment-button">' . 'Pay Now' . '</button>';
        if (!$this->remove_cancel_order_button) {
            $html .= '  <a class="button cancel" id="ourpass-cancel-payment-button" href="' . esc_url($order->get_cancel_order_url()) . '">' . 'Cancel order' . '</a></div>';
        }
        $html .= '</div>';
        $html .= '</div>';

        echo $html;
    }

    /**
     * Verify Ourpass payment.
     */
    public function verify_ourpass_transaction()
    {
        $ourpass_reference = false;

        if (isset($_REQUEST['ourpass_reference'])) {
            $ourpass_reference = sanitize_text_field($_REQUEST['ourpass_reference']);
        }

        @ob_clean();

        if(!$ourpass_reference) {
            wp_redirect(wc_get_page_permalink('cart'));
            exit;
        }

        $refSectionsArray = explode('_', $ourpass_reference);

        if(
            !(isset($refSectionsArray[0]) && $refSectionsArray[0] === 'WC' &&
            isset($refSectionsArray[1]) && $refSectionsArray[1] === 'ORDER' &&
            isset($refSectionsArray[2]) && isset($refSectionsArray[3]))
        ) {
            wp_redirect(wc_get_page_permalink('cart'));
            exit;
        }

        $order_id = (int) $refSectionsArray[2];
        $order = wc_get_order($order_id);

        if(! $order) {
            wp_redirect(wc_get_page_permalink('cart'));
            exit;
        }

        $ourpass_url = $this->ourpass_base_url. '/business/seller-user-check';

        $body = array(
            "ref" => $ourpass_reference,
            "api_key" => $this->secret_key
        );

        $args = array(
            'timeout' => 60,
            'body' => $body
        );

        $request = wp_remote_post($ourpass_url, $args);

        if (!(!is_wp_error($request) && in_array(wp_remote_retrieve_response_code($request), [200, 201]))){
            wp_redirect($this->get_return_url($order));
            exit;
        }

        $response = json_decode(wp_remote_retrieve_body($request));

        if(! (bool) $response->status) {
            $order->update_status('failed', 'Payment was declined by ourpass.');
            wp_redirect($this->get_return_url($order));
            exit;
        }

        //Order has already been processed before.
        if (in_array($order->get_status(), array('processing', 'on-hold', 'completed'))) {
            wp_redirect($this->get_return_url($order));
            exit;
        }
        
        $order->payment_complete($ourpass_reference);
        $order->add_order_note(sprintf('Payment via ourpass was successful (Transaction Reference: %s)', $ourpass_reference));

        if ($this->is_autocomplete_order_enabled($order)) {
            $order->update_status('completed');
        }

        function_exists('wc_reduce_stock_levels') ? wc_reduce_stock_levels($order_id) : $order->reduce_order_stock();

        WC()->cart->empty_cart();

        wp_redirect($this->get_return_url($order));
        exit;
    }


    /**
     * Checks if autocomplete order is enabled for the payment method.
     *
     * @since 5.7
     * @param WC_Order $order Order object.
     * @return bool
     */
    protected function is_autocomplete_order_enabled($order)
    {
        $autocomplete_order = false;

        $payment_method = $order->get_payment_method();

        $ourpass_settings = get_option('woocommerce_' . $payment_method . '_settings');

        if (isset($ourpass_settings['autocomplete_order']) && 'yes' === $ourpass_settings['autocomplete_order']) {
            $autocomplete_order = true;
        }

        return $autocomplete_order;
    }
}
