<?php
defined( 'ABSPATH') || exit ("no access");

if (!wp_verify_nonce($_REQUEST['_wpnonce'])) {
    wp_die('دسترسی غیر مجاز');
}

$data = $_POST;

if (!isset($data['coupon_id']) || !isset($data['action'])) return;

$coupon_id=(int)sanitize_text_field($data['coupon_id']);
$coupon=wc_get_coupon_code_by_id( $coupon_id );
if (!$coupon) return;
global $wpdb;
if ($data['action']=='archvie') {
    $wpdb->update($wpdb->posts,['post_status'=>'draft'],['ID'=>$coupon_id]);
}else{
//    $wpdb->update($wpdb->posts,['post_status'=>'publish'],['ID'=>$coupon_id]);
}
wp_redirect(home_url('hamsaz/products/coupons/'));