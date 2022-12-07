<?php
defined( 'ABSPATH') || exit ("no access");

if (!wp_verify_nonce($_REQUEST['_wpnonce'])) {
    wp_die('دسترسی غیر مجاز');
}

$data = $_POST;

if (!isset($data['product_id']) || !isset($data['action'])) return;

$product_id=(int)sanitize_text_field($data['product_id']);
$product=wc_get_product($product_id);
if (!$product) return;
xdebug_break();
if ($data['action']=='archvie') {
    $product->set_status( 'pending' );
    $product->save();
}else{
    $product->set_status( 'publish' );
    $product->save();
}
wp_redirect(home_url('hamsaz/products/'));