<?php

/**
 * Fast WooCommerce product attributes route object.
 */
class OurPass_Routes_OurPass_Data_From_Product extends OurPass_Routes_Route {

	/**
	 * Route name.
	 *
	 * @var string
	 */
	protected $route = 'product/data';

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

            $product_id = $this->request->get_param('productId');
            $variant_id = $this->request->get_param('variantId');
            $quantity = $this->request->get_param('quantity');

            if (empty($quantity)) {
                throw new \Exception('Quantity invalid');
            }

            if (empty($product_id)) {
                throw new \Exception('Product ID invalid');
            }

            $product = \wc_get_product(strval($product_id));

            if (empty($product)) {
                throw new \Exception('Product ID invalid');
            }

            $productData = array();
            $productData['name'] = $product->get_name();
            $productData['description'] = $product->get_name();
            $productData['email'] = '';
            $productData['amount'] = floatval($product->get_price());
            $productData['qty'] = intval($quantity);
            $productData['src'] = wp_get_attachment_image_url($product->get_image_id(), 'full');
            $productData['url'] = preg_replace("#^[^:/.]*[:/]+#i", "", urldecode(get_permalink($product_id)));
            $productData['metadata']['product_id'] = $product->get_id();

            if($product->is_type( 'variable' ) && !empty( $variant_id )) {

                $var_product = new  WC_Product_Variation($variant_id);

                $productData['name'] = $var_product->get_name();
                $productData['description'] = $var_product->get_name();
                $productData['amount'] = floatval($var_product->get_price());
                $productData['src'] = wp_get_attachment_image_url($var_product->get_image_id(), 'full');
                $productData['metadata']['variation_id'] = $variant_id;
                $productData['metadata']['variation'] = $this->get_product_variant_attributes($var_product->get_attributes()); 
            }         

            $ourpass_data = array();

            $ourpass_data['env'] = OURPASSWC_ENVIRONMENT;
            $ourpass_data['api_key'] = ourpasswc_get_secret_key();
            $ourpass_data['reference'] = 'WC_CHECKOUT_'.time();
            $ourpass_data['amount'] = $productData['amount'] * $productData['qty'];
            $ourpass_data['discount'] = '';
            $ourpass_data['qty'] = 1;
            $ourpass_data['name'] = $productData['name'];
            $ourpass_data['description'] = $productData['description'];
            $ourpass_data['email'] = '';
            $ourpass_data['src'] = $productData['src'];
            $ourpass_data['url'] = $productData['url'];
            $ourpass_data['items'][] = [
                'name' =>  $productData['name'],
                'description' => $productData['description'],
                'email' => '',
                'amount' => $productData['amount'],
                'qty' => $productData['qty'],
                'src' => $productData['src'],
                'url' => $productData['url'],
                'metadata' => $productData['metadata']
            ];

            return new \WP_REST_Response([
                'success' => true,
                'message' => 'checkout detail fetch',
                'data' => $ourpass_data
            ], 200);

        }catch(\Exception $error) {
			return new \WP_REST_Response([
				'success' => false,
				'message' => $error->getMessage(),
			], 400);
		}
	}
    
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