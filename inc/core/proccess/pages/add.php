<?php

defined( 'ABSPATH') || exit ("no access");

if (!wp_verify_nonce($_REQUEST['_wpnonce'])) {
    wp_die('دسترسی غیر مجاز');
}

$data = $_POST;

$post_id=(int)sanitize_text_field($data['post_id']);
$image=sanitize_text_field($data['image-uploader']);

$upload_id='';
if (is_numeric($image)) {
    $upload_id = $image;
}else {
    $new_image = \HamyarSaz\core\helpers::saveImage( $image );
    if ( is_numeric( $new_image ) ) {
        $upload_id = $new_image;
    }
}



$title=sanitize_text_field($data['title']);
$description=sanitize_textarea_field($data['description']);


$terms = get_terms( ['taxonomy'=>'category','hide_empty' => false] );
$terms = array_column($terms, 'term_id');
$categories=$data['categories']??[$terms[0]];

foreach ($categories as $category){
    if (!is_numeric($category)){
        $category=sanitize_text_field($category);
        $term = term_exists( $category, 'category' );
        if ($term !== 0 && $term !== null) {
            $categories[]=$term['term_id'];
        }else{
            $term = wp_insert_term( $category, 'category' );
            if (is_wp_error($term)){
                wp_die('خطا در ثبت دسته بندی' );
            }
            $categories[]=$term['term_id'];
        }
    }
}
$arg = [
    'post_title'=>$title,
    'post_content'=>$description,
    'post_status'=>'publish',
    'post_type'=>'page',
    'post_author'=>get_current_user_id(),
    'post_category'=>$categories,
];
if (!empty($post_id)){
    $post=WP_Post::get_instance($post_id);
    if (empty($post) || is_wp_error($post)){
        wp_die('محصول مورد نظر یافت نشد');
    }
    $arg['ID']=$post_id;
}

$post_ID=wp_insert_post($arg);

if (!empty($upload_id)) {
    set_post_thumbnail( $post_ID, $upload_id );
}else{
    delete_post_thumbnail( $post_ID );
}
wp_redirect(home_url('hamsaz/pages/'));