<?php
namespace HamyarSaz\core\ajax;

use HamyarSaz\core\helpers;
use HamyarSaz\core\ajax;


class hostRegister{
    protected static $_instance = null;

    public static function get_instance() {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function __construct() {
        $this->define_hooks();
    }

    public function define_hooks(){
        add_action( 'wp_ajax_register-host', [$this, 'ajax'] );
    }


    public function ajax(){
        ajax::hasPermission();

        $_website_wizard=get_user_meta(get_current_user_id(),'_website_wizard',true);
        if (empty($_website_wizard)){
            wp_send_json_error(['message'=>'نقص در اطلاعات','javascript'=>"hs_next_step('start')"] );
        }
        $data = $_POST;
        if ( ! wp_verify_nonce( $data['_wpnonce'] )) {
            wp_send_json_error(['message'=>'ورودی نامعتبر می‌باشد. لطفا صفحه را مجدد باز کرده و اقدام نمایید' ]);
        }
        $username=sanitize_text_field($data['username']);
        $password=sanitize_text_field($data['password']);
        $server=sanitize_text_field($data['server']);
        $data=[
            'username'=>$username,
            'password'=>$password,
            'server'=>$server,
        ];
        if (empty($username) || empty($password) || empty($server)){
            wp_send_json_error(['message'=>'وارد کردن اطلاعات هاست اجباری می‌باشد.' ]);
        }

        $_website_wizard['register-host']=$data;
        update_user_meta(get_current_user_id(),'_website_wizard',$_website_wizard);

        wp_send_json_success(['message'=>'اطلاعات ما موفقیت ثبت شد','javascript'=>"hs_next_step('register-zarinpal')"] );
    }
}