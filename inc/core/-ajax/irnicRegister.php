<?php
namespace HamyarSaz\core\ajax;

use HamyarSaz\core\helpers;
use \HamyarSaz\core\ajax;


class irnicRegister{
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
        add_action( 'wp_ajax_irnic-register', [$this, 'ajax'] );
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
        $irnic=sanitize_text_field($data['irnic']);
        $data=[
            'irnic'=>$irnic,
        ];
        if (empty($irnic)){
            wp_send_json_error(['message'=>'وارد کردن شناسه ایرنیک اجباری می‌باشد' ]);
        }

        $_website_wizard['register-irnic']=$data;
        update_user_meta(get_current_user_id(),'_website_wizard',$_website_wizard);

        wp_send_json_success(['message'=>'اطلاعات ما موفقیت ثبت شد','javascript'=>"hs_next_step('register-domain')"] );
    }
}