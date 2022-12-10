<?php

defined( 'ABSPATH') || exit ("no access");

if (!wp_verify_nonce($_REQUEST['_wpnonce'])) {
    wp_die('دسترسی غیر مجاز');
}
$package=new \HamyarSaz\core\package();

if (isset($_REQUEST['site_id']) && !empty($_REQUEST['site_id'])){
    $user_site=$package->getPackages(null,(int)$_REQUEST['site_id']);

    if (empty($user_site)){
        wp_die('دسترسی غیر مجاز');
    }
}

if (empty($_REQUEST['title']) || empty($_REQUEST['category'])){
    $_POST['errors']=['لطفا تمامی فیلد ها را پر کنید'];
    return;
}
if (strlen($_REQUEST['title'])>50){
    $_POST['errors']=['عنوان وبسایت نمی‌تواند بیشتر از 50 کاراکتر باشد'];
    return;
}

$package->createPackage(null,$_REQUEST['title'],$_REQUEST['category']);

wp_redirect(home_url('hamsaz/dashboard'));