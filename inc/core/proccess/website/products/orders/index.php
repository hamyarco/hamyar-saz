<?php

defined( 'ABSPATH') || exit ("no access");

if (!wp_verify_nonce($_REQUEST['_wpnonce'])) {
    wp_die('دسترسی غیر مجاز');
}

$data = $_POST;

$order_id=(int)sanitize_text_field($data['order-id']);
$order = wc_get_order( $order_id );
if ( ! $order ) {
    wp_die('سفارشی یافت نشد');
}
$order->set_status($data['order-status']);
$order->save();

wp_redirect(home_url('hamsaz/products/orders/'));