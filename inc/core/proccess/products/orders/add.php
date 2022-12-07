<?php

defined( 'ABSPATH') || exit ("no access");

if (!wp_verify_nonce($_REQUEST['_wpnonce'])) {
    wp_die('دسترسی غیر مجاز');
}

$data = $_POST;

$product_id=(int)sanitize_text_field($data['product_id']);
$product_image=sanitize_text_field($data['image-uploader']);

$product_images=$data['product-images']??[];
if (!empty($product_image)){
    $product_images[]=$product_image;
}
$upload_id=[];
foreach ($product_images as $image){
    if (is_numeric($image)) {
        $upload_id[] = $image;
        continue;
    }
    $new_image=\HamyarSaz\core\helpers::saveImage($image);
    if (is_numeric($new_image)){
        $upload_id[]=$new_image;
    }
}

$title=sanitize_text_field($data['title']);
$description=sanitize_textarea_field($data['description']);
$price=(int)sanitize_text_field($data['price']);
$sales_price=(int)sanitize_text_field($data['sales_price']);

$stock='';
if (isset($data['stock'])){
    if ($data['stock']!==''){
        $stock=(int)sanitize_text_field($data['stock']);
    }
}

$terms = get_terms( ['taxonomy'=>'product_cat','hide_empty' => false] );
$terms = array_column($terms, 'term_id');
$categories=$data['categories']??[$terms[0]];

foreach ($categories as $category){
    if (!is_numeric($category)){
        $category=sanitize_text_field($category);
        $term = term_exists( $category, 'product_cat' );
        if ($term !== 0 && $term !== null) {
            $categories[]=$term['term_id'];
        }else{
            $term = wp_insert_term( $category, 'product_cat' );
            if (is_wp_error($term)){
                wp_die('خطا در ثبت دسته بندی' );
            }
            $categories[]=$term['term_id'];
        }
    }
}

if (!empty($product_id)){
    $product=wc_get_product($product_id);
    if (empty($product) || is_wp_error($product)){
        wp_die('محصول مورد نظر یافت نشد');
    }
}else{
    $product= new \WC_Product();
}

$product->set_category_ids($categories);
$product->set_name($title);
$product->set_description($description);
$product->set_regular_price($price);

if (!empty($sales_price)){
    $product->set_sale_price($sales_price);
}

foreach ($upload_id as $key => $image_id){
    if ($key==0){
        $product->set_image_id($image_id);
    }
    $product->set_gallery_image_ids($image_id);
}
if (empty($upload_id)){
    $product->set_gallery_image_ids([]);
    $product->set_image_id(0);
}

if ($stock===''){
    $product->set_manage_stock(false);
    $product->set_stock_quantity( '' );

}else{
    $product->set_manage_stock(true);
    $product->set_stock_quantity($stock);
}

$product->save();
wp_redirect(home_url('hamsaz/products/'));