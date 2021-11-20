<?php

/**
 * Fast WooCommerce product attributes route object.
 */
class OurPass_Routes_OurPass_Data_From_Cart extends OurPass_Routes_Route {

	/**
	 * Route name.
	 *
	 * @var string
	 */
	protected $route = 'cart-data';

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

            $cart = WC()->cart;
        
            if (empty($cart)) {
                throw new \Exception('Cart is empty');
            }

            $ourpass_data = array();

            $ourpass_data['env'] = 'production';
            $ourpass_data['api_key'] = ourpasswc_get_secret_key();
            $ourpass_data['reference'] = '';
            $ourpass_data['amount'] = floatval($cart->total);
            $ourpass_data['discount'] = '';
            $ourpass_data['qty'] = 1;
            $ourpass_data['email'] = '';

            //Getting the items;
            $items = [];

            foreach ($cart->get_cart() as  $cart_item) {
                $product_id = strval($cart_item['product_id']);
                $product = wc_get_product($product_id);

                $productInfo = [
                    'id' => $product->get_id(),
                    'name' =>  $product->get_name(),
                    'description' => $product->get_name(),
                    'amount' => $cart_item['line_total'],
                    'qty' => strval(intval($cart_item['quantity'])),
                    'src' => wp_get_attachment_image_url($product->get_image_id(), 'full'),
                    'url' => preg_replace("#^[^:/.]*[:/]+#i", "", urldecode(get_permalink($product_id))),
                    'email' => '',
					'metadata' => [
						'variation_id' => strval($cart_item['variation_id']),
						'variation' => $cart_item['variation']
					]
                ];

                $items[] = $productInfo;
            }

            $ourpass_data['items'] = $items;

            if ($ourpass_data['items'][0]) {
                $ourpass_data['name'] = $ourpass_data['items'][0]['name'];
                $ourpass_data['description'] = $ourpass_data['items'][0]['description'];
                $ourpass_data['src'] = $ourpass_data['items'][0]['src'];
                $ourpass_data['url'] = $ourpass_data['items'][0]['url'];
            }

            return new \WP_REST_Response([
                'success' => true,
                'message' => 'checkout detail fetch',
                'data' => $ourpass_data
            ], 200);

        }catch(\Exception $error) {
			return new \WP_Error(400, $error->getMessage(), [
				'success' => false,
				'message' => $error->getMessage(),
			]);
		}
	}
}
