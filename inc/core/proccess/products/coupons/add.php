<?php

defined( 'ABSPATH') || exit ("no access");

if (!wp_verify_nonce($_REQUEST['_wpnonce'])) {
    wp_die('دسترسی غیر مجاز');
}

$data = $_POST;
xdebug_break();
$coupon_id=(int)sanitize_text_field($data['coupon_id']);

$title=sanitize_text_field($data['title']);
$description=sanitize_textarea_field($data['description']);
$amount=(int)sanitize_text_field($data['amount']);
$count=(int)sanitize_text_field($data['count']);
$arg = [
    'post_title'=>$title,
    'post_name'=>$title,
    'excerpt'=>$description,
    'post_status'=>'publish',
    'post_author'=>get_current_user_id(),
];
if (!empty($coupon_id)){
    $coupon=new \WC_Coupon($coupon_id);
    if (!$coupon) {
        wp_die( 'کپن یافت نشد' );
    }
}else{
    $coupon= new \WC_Coupon();
}

$coupon->set_code($title);
$coupon->set_description($description);
$coupon->set_status('publish');
$coupon->set_amount($amount);
$coupon->set_usage_count($count);



$usable_product=$data['usable_product']??false;
if (!empty($usable_product)){
    $product=wc_get_product($usable_product);
    if (empty($product))
        wp_die('این محصول وجود ندارد');

    $coupon->set_product_ids([$product->get_id()]);
}


$coupon->save();
wp_redirect(home_url('hamsaz/products/coupons/'));