<?php

/**
 * OurPass WooCommerce product attributes route object.
 */
class OurPass_Routes_OurPass_Data_From_Cart extends OurPass_Routes_Route
{

    /**
     * Route name.
     *
     * @var string
     */
    protected $route = 'cart/data';

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
    public function callback($request)
    {
        try {
            $this->request = $request;

            $cart = WC()->cart;

            md5(uniqid(rand(), true));

            if (empty($cart)) {
                throw new \Exception('Cart is empty');
            }

            //Getting the items;
            $items = array();

            foreach ($cart->get_cart() as  $cart_item) {
                $product_id = strval($cart_item['product_id']);
                $product = wc_get_product($product_id);

                $productInfo = [
                    'name' =>  $product->get_name(),
                    'description' => $product->get_name(),
                    'amount' => $cart_item['line_total'],
                    'qty' => intval($cart_item['quantity']),
                    'src' => wp_get_attachment_image_url($product->get_image_id(), 'full'),
                    'url' => preg_replace("#^[^:/.]*[:/]+#i", "", urldecode(get_permalink($product_id))),
                    'email' => '',
                    'metadata' => [
                        'product_id' => $product->get_id(),
                        'variation_id' => strval($cart_item['variation_id']),
                        'variation' => $cart_item['variation']
                    ]
                ];

                $items[] = $productInfo;
            }

            if (!isset($items[0]) && empty($items[0])) {
                throw new Exception('Cart is empty');
            }

            $ourpass_data = array();

            $ourpass_data['env'] = OURPASSWC_ENVIRONMENT;
            $ourpass_data['api_key'] = ourpasswc_get_secret_key();
            $ourpass_data['reference'] = 'WC_CHECKOUT_' . md5(uniqid(bin2hex(random_bytes(20)), true));
            $ourpass_data['amount'] = floatval($cart->total);
            $ourpass_data['discount'] = '';
            $ourpass_data['qty'] = 1;
            $ourpass_data['name'] = $items[0]['name'];
            $ourpass_data['description'] = $items[0]['description'];
            $ourpass_data['email'] = '';
            $ourpass_data['src'] = $items[0]['src'];
            $ourpass_data['url'] = $items[0]['url'];
            $ourpass_data['items'] = $items;

            return new \WP_REST_Response([
                'success' => true,
                'message' => 'checkout detail fetch',
                'data' => $ourpass_data
            ], 200);
        } catch (\Exception $error) {
            return new \WP_REST_Response([
                'success' => false,
                'message' => $error->getMessage(),
            ], 400);
        }
    }
}
