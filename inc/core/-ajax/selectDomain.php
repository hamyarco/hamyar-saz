<?php
namespace HamyarSaz\core\ajax;

use HamyarSaz\core\helpers;
use \HamyarSaz\core\ajax;


class selectDomain{
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
        add_action( 'wp_ajax_select-domain', [$this, 'selectDomain'] );
    }


    public function selectDomain(){
        ajax::hasPermission();

        $_website_wizard=get_user_meta(get_current_user_id(),'_website_wizard',true);
        if (empty($_website_wizard)){
            wp_send_json_error(['message'=>'نقص در اطلاعات','javascript'=>"hs_next_step('start')"] );
        }

        $data = $_POST;
        if ( ! wp_verify_nonce( $data['_wpnonce'] )) {
            wp_send_json_error(['message'=>'ورودی نامعتبر می‌باشد. لطفا صفحه را مجدد باز کرده و اقدام نمایید' ]);
        }
        if ( empty($data['domain-selector']) ){
            wp_send_json_error(['message'=>'لطفا یکی از گزینه های دامنه را انتخاب نمایید' ]);
        }
        $next_step='register-irnic';
        if ($data['domain-selector']=='have-domain'){
            if (empty($data['domain-name'])){
                wp_send_json_error(['message'=>'لطفا نام دامنه را وارد نمایید' ]);
            }
            $next_step='set-dns';
        }else{
            if (empty($data['domain-register'])){
                wp_send_json_error(['message'=>'لطفا یکی از گزینه های ثبت دامنه را انتخاب نمایید' ]);
            }
            unset($data['domain-name']);
            if ($data['domain-register']=='hamyar'){
                $next_step='register-domain-hamyar';
            }
        }

        unset($data['_wpnonce']);
        unset($data['_wp_http_referer']);
        $_website_wizard['select-domain']=$data;
        update_user_meta(get_current_user_id(),'_website_wizard',$_website_wizard);

        wp_send_json_success(['javascript'=>"hs_next_step('{$next_step}')"] );
    }
}