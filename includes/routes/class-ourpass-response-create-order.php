<?php

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

            $reference = $this->request->get_param('reference');

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

    protected function createOrder($data)
    {
        global $woocommerce;

        $billingAddress = array(
            'first_name' => '111Joe',
            'last_name'  => 'Conlin',
            'company'    => 'Speed Society',
            'email'      => 'joe@testing.com',
            'phone'      => '760-555-1212',
            'address_1'  => '123 Main st.',
            'address_2'  => '104',
            'city'       => 'San Diego',
            'state'      => 'Ca',
            'postcode'   => '92121',
            'country'    => 'US'
        );

        $user = get_user_by('login', $data['customer']['email']);

        // $user = get_current_user_id();
        
        if(! $user = $user->ID) {
            $user = wc_create_new_customer($data['customer']['email'], $data['customer']['email'], wp_generate_password());
        }


        // Now we create the order
        $order = wc_create_order();

        $order->set_customer_id($user);
        $order->set_address($billingAddress, 'billing');
        $order->set_address($billingAddress, 'shipping');

        $order->add_product(wc_get_product('275962'), 1); 
        //
        $order->calculate_totals();
        $order->payment_complete($data['reference']);
        $order->update_status("Completed", 'Order completed via OurPass', TRUE);
        $order->update_meta_data('ourpass_checkout_reference', $data['reference']);
        $order->save();

        return $order;
    }

    protected function getOurPassReferenceData($reference)
    {
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

        if (!(!is_wp_error($request) && in_array(wp_remote_retrieve_response_code($request), [200, 201]))) {
            throw new Exception('Unable to reach OurPass endpoint');
            exit;
        }

        return json_decode(wp_remote_retrieve_body($request), true);
    }

    // public function getProduct()
    // {
    //     $products_to_add = array();

    //     // Loop through the $imported_order_items array to check if it's simple or variable   
    //     foreach ($imported_order_items as $item) {

    //         // get the product id and define the $product variable
    //         $id = wc_get_product_id_by_sku($item['SKU']);
    //         $product = wc_get_product($id);

    //         // Check if product is variable
    //         if ($product->is_type('variable')) {

    //             $available_variations = $product->get_available_variations();

    //             foreach ($available_variations as $variation) {

    //                 $variation_id = $variation['variation_id'];

    //                 $var_product = wc_get_product($variation_id);

    //                 $atts = $var_product->get_attributes();


    //                 // Conditional to check for variations that are varied by both size and colour

    //                 if (isset($atts['pa_shirt-size']) && $atts['pa_shirt-size'] === strtolower($item['size']) && isset($atts['pa_colour']) && $atts['pa_colour'] === strtolower($item['colour'])) {

    //                     // check if the key exists and add to the value, if not we'll define it
    //                     if (!array_key_exists($variation_id, $products_to_add)) {

    //                         $products_to_add[$variation_id] = $item['qty'];
    //                     } else {

    //                         $products_to_add[$variation_id] += $item['qty'];
    //                     }
    //                 }

    //                 // only comes in shirt size variations, so we don't look for colour
    //                 else if (isset($atts['pa_shirt-size']) && $atts['pa_shirt-size'] === strtolower($item['size']) && !isset($atts['pa_colour'])) {

    //                     // check if the key exists and add to the value, if not we'll define it
    //                     if (!array_key_exists($variation_id, $products_to_add)) {

    //                         $products_to_add[$variation_id] = $item['qty'];
    //                     } else {

    //                         $products_to_add[$variation_id] += $item['qty'];
    //                     }
    //                 }

    //                 // only comes in blouse size variations
    //                 else if (isset($atts['pa_blouse_size']) && $atts['pa_blouse_size'] === strtolower($item['size'])) {

    //                     // check if the key exists and add to the value, if not we'll define it
    //                     if (!array_key_exists($variation_id, $products_to_add)) {

    //                         $products_to_add[$variation_id] = $item['qty'];
    //                     } else {

    //                         $products_to_add[$variation_id] += $item['qty'];
    //                     }
    //                 }
    //             } // end $available_variations foreach loop      
    //         }
    //         else {
    //             $products_to_add[$product->get_id()] = $item['qty'];
    //         }
    //     }
    // }
    
    protected function get_product_variant_attributes($attributes)
    {
        $return = array();

        foreach ($attributes as $key => $value) {
            $return[$this->standardize_attribute_key($key)] = $value;
        }

        return $return;
    }
    
    protected function standardize_attribute_key($att_key)
    {
        return 'attribute_' . sanitize_title($att_key);
    }
}
