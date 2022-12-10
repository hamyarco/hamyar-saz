<?php

defined( 'ABSPATH') || exit ("no access");

if (!wp_verify_nonce($_REQUEST['_wpnonce'])) {
    wp_die('دسترسی غیر مجاز');
}

$data = $_POST['payment'];

$bacs_settings=get_option( 'woocommerce_bacs_settings', ['enabled'=>'no','title'=>'انتقال مستقیم بانکی','description'=>'پرداخت خود را مستقیما به حساب بانکی ما واریز کنید.خواهشمندیم شماره سفارش خود  استفاده کنید.سفارش شما تا زمانی که وجوه به حساب ما وارد نشود ارسال نخواهد شد.'] );
$bacs=get_option(
    'woocommerce_bacs_accounts',
    array(
        array(
            'account_name'   => '',
            'account_number' => '',
            'sort_code'      => '',
            'bank_name'      => '',
            'iban'           => '',
            'bic'            => '',
        ),
    )
);
$bacs_settings['enabled']=$data['bacs']['enabled'];
$bacs_settings['title']=$data['bacs']['title'];
$bacs_settings['description']=$data['bacs']['description'];
$bacs[0]['account_name']=$data['bacs']['account_name'];
$bacs[0]['account_number']=$data['bacs']['account_number'];
$bacs[0]['sort_code']=$data['bacs']['sort_code'];
$bacs[0]['bank_name']=$data['bacs']['bank_name'];
$bacs[0]['iban']=$data['bacs']['iban'];

update_option( 'woocommerce_bacs_settings', $bacs_settings );
update_option( 'woocommerce_bacs_accounts', $bacs );

wp_redirect(home_url('hamsaz/settings/payment/'));