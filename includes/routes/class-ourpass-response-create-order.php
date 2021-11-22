<?php

defined('ABSPATH') || exit;

/**
 * OurPass WooCommerce product attributes route object.
 */
class OurPass_Routes_OurPass_Response_Create_Order extends OurPass_Routes_Route {

	/**
	 * Route name.
	 *
	 * @var string
	 */
	protected $route = 'order';

	/**
	 * Route methods.
	 *
	 * @var string
	 */
	protected $methods = 'POST';

	/**
	 * Permission callback.
	 *
	 * @var callable
	 */
	protected $permission_callback = '__return_true';

	/**
	 * Utility to get information on installed plugins.
	 *
	 * @param WP_REST_Request $request JSON request for shipping endpoint.
	 *
	 * @return array|WP_Error|WP_REST_Response
	 */
	public function callback( $request ) {
        try {
            $this->request = $request;

            $_REQUEST['_wpnonce'] = (isset($_SERVER['HTTP_X_WP_NONCE'])) ? $_SERVER['HTTP_X_WP_NONCE'] : '';

            if (!check_ajax_referer('wp_rest', '', false)) {
                throw new \Exception('Invalid Request');
            }

            $reference = $this->request->get_param('reference');

            if(empty($reference)) {
                throw new Exception("Checkout reference code is required");
            }

            $data = $this->getOurPassReferenceData($reference);

            if(! $data['status']) {
                throw new Exception("Checkout wasn't successful");
            }

            $this->createOrder($data["data"]);

            return new \WP_REST_Response([
                'success' => true,
                'message' => 'order created successfully',
            ], 200);

        }catch(\Exception $error) {
			return new \WP_REST_Response([
				'success' => false,
				'message' => $error->getMessage(),
			], 400);
		}
	}

    /**
     * Undocumented function
     *
     * @param array $data
     * @return \WC_Order|\WP_Error|bool
     */
    protected function createOrder($data)
    {
        global $woocommerce;

        $products = $this->parseProductIdAndQuantity($data['items']);

        if(count($products) === 0) {
            throw new Exception("Product is empty");
        }

        $user = get_current_user_id();

        if($user === 0) {
            $user = get_user_by('login', $data['customer']['email']);

            if($user) {
                $user = $user->ID;
            }else{
                $user = wc_create_new_customer($data['customer']['email'], $data['customer']['email'], wp_generate_password());
                
                if(is_wp_error($user)) {
                    throw new Exception('Unable to create user for new order');
                }
                
                wp_update_user([
                    'ID' => $user,
                    'display_name' => $data['customer']['first_name'].' '.$data['customer']['last_name'],
                    'first_name' => $data['customer']['first_name'],
                    'last_name' => $data['customer']['last_name']
                ]);
            }
        }

        // Now we create the order
        $order = wc_create_order();

        $order->set_customer_id($user);

        if(!empty($data['billing_address'])) {
            $order->set_address(array(
                'first_name' => $data['billing_address']['first_name'],
                'last_name'  => $data['billing_address']['last_name'],
                'email'      => $data['billing_address']['email'],
                'phone'      => $data['billing_address']['phone'],
                'company'    => $data['billing_address']['company'],
                'address_1'  => $data['billing_address']['address_1'],
                'address_2'  => $data['billing_address']['address_2'],
                'city'       => $data['billing_address']['city'],
                'state'      => $data['billing_address']['state'],
                'postcode'   => $data['billing_address']['postcode'],
                'country'    => $data['billing_address']['country']
            ), 'billing');
        }

        if(!empty($data['shipping_address'])) {
            $order->set_address(array(
                'first_name' => $data['shipping_address']['first_name'],
                'last_name'  => $data['shipping_address']['last_name'],
                'email'      => $data['shipping_address']['email'],
                'phone'      => $data['shipping_address']['phone'],
                'company'    => $data['shipping_address']['company'],
                'address_1'  => $data['shipping_address']['address_1'],
                'address_2'  => $data['shipping_address']['address_2'],
                'city'       => $data['shipping_address']['city'],
                'state'      => $data['shipping_address']['state'],
                'postcode'   => $data['shipping_address']['postcode'],
                'country'    => $data['shipping_address']['country']
            ), 'shipping');
        }

        foreach($products as $product) {
            $order->add_product($product['product'], $product['qty'], $product['args']); 
        }

        $order->calculate_totals();

        $order->payment_complete($data['reference']);

        $order->update_status("completed", 'Order completed via OurPass', TRUE);

        $order->update_meta_data('ourpass_checkout_reference', $data['reference']);

        return $order;
    }

    protected function parseProductIdAndQuantity($items)
    {
        $return = array();

        foreach($items as $item)
        {
            $args = array();

            // get the product id and define the $product variable
            $product = wc_get_product($item['metadata']['product_id']);

            // Check if product is variable
            if ($product->is_type('variable') && !empty($item['metadata']['variation_id'])) {

                $var_product = new WC_Product_Variation($item['metadata']['variation_id']);

                $product = wc_get_product($var_product->get_id());

                $args['product'] = $product;
                $args['qty'] = $item['qty'];
                $args['args'] = [
                    'subtotal' => wc_get_price_excluding_tax($product, array('qty' => $item['qty'], 'price' => $item['amount'])),
                    'total' => wc_get_price_excluding_tax($product, array('qty' => $item['qty'], 'price' => $item['amount'])),
                ];
            }
            else {
                $args['product'] = $product;
                $args['qty'] = $item['qty'];
                $args['args'] = [
                    'subtotal' => wc_get_price_excluding_tax($product, array('qty' => $item['qty'], 'price' => $item['amount'])),
                    'total' => wc_get_price_excluding_tax($product, array('qty' => $item['qty'], 'price' => $item['amount'])),
                ];
            }

            $return[] = $args;
        }

        return $return;
    }

    protected function getOurPassReferenceData($reference)
    {
        //SAMPLE
        $string = file_get_contents(OURPASSWC_PATH. "samples/sample-verification.json");
        return json_decode($string, true);

        //REAL
        $baseUrl = OURPASSWC_ENVIRONMENT === 'production' ? OURPASSWC_PRODUCTION_BASE_URL : OURPASSWC_SANDBOX_BASE_URL;

        $ourpass_url = $baseUrl . '/business/seller-user-check';

        $body = array(
            "ref" => $reference,
            "api_key" => ourpasswc_get_secret_key(),
        );

        $args = array(
            'timeout' => 60,
            'body' => $body
        );

        $request = wp_remote_post($ourpass_url, $args);

        if(is_wp_error($request)) {
            throw new Exception('Unable to reach OurPass endpoint');
        }

        if (! in_array(wp_remote_retrieve_response_code($request), [200, 201])) {
            throw new Exception("Checkout verification wasn't successful");
        }

        return json_decode(wp_remote_retrieve_body($request), true);
    }
}
