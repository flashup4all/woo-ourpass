<?php

use Automattic\WooCommerce\Utilities\NumberUtil;

defined('ABSPATH') || exit;

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

            $_REQUEST['_wpnonce'] = (isset($_SERVER['HTTP_X_WP_NONCE'])) ? $_SERVER['HTTP_X_WP_NONCE'] : '';

            if (!check_ajax_referer('wp_rest', '', false)) {
                throw new \Exception('Invalid Request');
            }

            $cart = WC()->cart;

            if (empty($cart)) {
                throw new \Exception('Cart is empty');
            }

            //Getting the items;
            $items = array();
            $itemsMetaData = array();

            foreach ($cart->get_cart() as  $cart_item) {
                $product_id = strval($cart_item['product_id']);
                $product = wc_get_product($product_id);

                $item_data = array(
                    'name' =>  $product->get_name(),
                    'description' => $product->get_name(),
                    'amount' => $cart_item['line_total'] / intval($cart_item['quantity']),
                    'qty' => intval($cart_item['quantity']),
                    'src' => wp_get_attachment_image_url($product->get_image_id(), 'full'),
                    'url' => preg_replace("#^[^:/.]*[:/]+#i", "", urldecode(get_permalink($product_id))),
                    'email' => ''
                );

                $metadata = array(
                    'product_id' => $product->get_id(),
                    'amount' => $cart_item['line_total'] / intval($cart_item['quantity']),
                    'qty' => intval($cart_item['quantity']),
                );

                if($cart_item['variation_id']) {
                    $metadata['variation_id'] = intval($cart_item['variation_id']);
                    $metadata['variation'] = $cart_item['variation'];
                }

                $items[] = $item_data;
                $itemsMetaData[] = $metadata;
            }

            if (!isset($items[0]) && empty($items[0])) {
                throw new Exception('Cart is empty');
            }

            $referenceCode = 'WC_CHECKOUT_' . md5(uniqid(bin2hex(random_bytes(20)), true)).''.ourpasswc_get_last_sale_order_post_id();

            $ourpass_data = array();

            $ourpass_data['env'] = OURPASSWC_ENVIRONMENT;
            $ourpass_data['api_key'] = ourpasswc_get_secret_key();
            $ourpass_data['reference'] = $referenceCode;
            $ourpass_data['amount'] = floatval($cart->total);
            $ourpass_data['qty'] = 1;
            $ourpass_data['name'] = $items[0]['name'];
            $ourpass_data['description'] = $items[0]['description'];
            $ourpass_data['email'] = '';
            $ourpass_data['src'] = $items[0]['src'];
            $ourpass_data['url'] = $items[0]['url'];
            $ourpass_data['items'] = $items;
            $ourpass_data['metadata'] = [
                'line_items_total' => floatval($cart->total),
                'items' => $itemsMetaData
            ];

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
