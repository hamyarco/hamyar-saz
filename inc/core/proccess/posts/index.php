<?php
defined( 'ABSPATH') || exit ("no access");

if (!wp_verify_nonce($_REQUEST['_wpnonce'])) {
    wp_die('دسترسی غیر مجاز');
}

$data = $_POST;

if (!isset($data['post_id']) || !isset($data['action'])) return;

$post_id=(int)sanitize_text_field($data['post_id']);
$post=WP_Post::get_instance($post_id );
if (!$post) return;

if ($data['action']=='archvie') {
    $post->post_status='pending';
    wp_update_post($post);
}else{
    $post->post_status='publish';
    wp_update_post($post);
}
wp_redirect(home_url('hamsaz/posts/'));