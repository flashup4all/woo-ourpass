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

            $reference = trim($this->request->get_param('reference'));

            if(empty($reference)) {
                throw new Exception("Checkout reference code is required");
            }

            if(substr($reference, 0, 12) !== "WC_CHECKOUT_") {
                throw new Exception("Invalid Checkout reference code");
            }

            if(!ourpasswc_reference_is_unique($reference)) {
                throw new Exception("Checkout reference already inserted");
            }

            $data = $this->getOurPassReferenceData($reference);

            if(! $data['status']) {
                throw new Exception("Checkout wasn't successful");
            }

            $this->createOrder($data["data"], $reference);

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

    
    protected function createOrder($data, $reference)
    {
        global $woocommerce;

        $metadata = isset($data['metadata']) ? $data['metadata'] : array();

        $metadata = is_array($metadata) ? $metadata : json_decode($data['metadata'], true);

        if(empty($metadata)) {
            throw new Exception("Invalid checkout order, metadata not available");
        }

        if (!isset($metadata['items']) && empty($metadata['items'])) {
            throw new Exception("Invalid checkout order, items not available");
        }

        $products = $this->parseProductIdAndQuantity($metadata['items']);

        if(count($products) < 1) {
            throw new Exception("Product is empty");
        }

        $user = get_current_user_id();

        if($user < 1) {
            $user = get_user_by('login', $data['email']);

            if($user) {
                $user = $user->ID;
            }else{
                $user = wc_create_new_customer($data['email'], $data['email'], wp_generate_password());
                
                if(is_wp_error($user)) {
                    throw new Exception('Unable to create user for new order');
                }

                $names = explode(" ", $data['name']);
                
                wp_update_user([
                    'ID' => $user,
                    'display_name' => $data['name'],
                    'first_name' => (isset($names[0])) ? $names[0] : '',
                    'last_name' => (isset($names[1])) ? $names[1] : '',
                ]);
            }
        }

        // Now we create the order
        $order = wc_create_order();

        $order->set_customer_id($user);

        if(isset($data['address'])) {

            $names = explode(" ", $data['name']);

            $address = [
                'first_name' => (isset($names[0])) ? $names[0] : '',
                'last_name' => (isset($names[1])) ? $names[1] : '',
                'email'      => $data['email'],
                'phone'      => $data['userMobile'],
                'address_1'  => $data['address'],
                'town'       => $data['townName'],
                'city'       => $data['cityName'],
                'state'      => $data['state'],
                'country'    => $data['country']
            ];

            $order->set_address($address, 'billing');
            $order->set_address($address, 'shipping');
        }

        foreach($products as $product) {
            $order->add_product($product['product'], $product['qty'], $product['args']); 
        }

        $order->calculate_totals();

        $order->add_meta_data(OURPASSWC_ORDER_REFERENCE_META_KEY, $reference, true);

        $order->payment_complete($reference);

        $note = "OurPass Checkout: Completed with reference key ". $reference;

        $order->update_status("completed", $note, TRUE);

        $order->save();

        return $order;
    }

    protected function parseProductIdAndQuantity($items)
    {
        $return = array();

        foreach($items as $item)
        {
            $args = array();

            // get the product id and define the $product variable
            $product = wc_get_product($item['product_id']);

            // Check if product is variable
            if ($product->is_type('variable') && !empty($item['variation_id'])) {

                $var_product = new WC_Product_Variation($item['variation_id']);

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
            throw new Exception('Unable to reach verification endpoint');
        }

        if (! in_array(wp_remote_retrieve_response_code($request), [200, 201])) {
            throw new Exception("Checkout verification wasn't successful, order does not exist or has been fulfilled");
        }

        return json_decode(wp_remote_retrieve_body($request), true);
    }
}
