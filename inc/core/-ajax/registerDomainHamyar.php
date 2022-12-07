<?php
namespace HamyarSaz\core\ajax;

use HamyarSaz\core\helpers;
use \HamyarSaz\core\ajax;


class registerDomainHamyar{
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
        add_action( 'wp_ajax_register-domain-hamyar', [$this, 'ajax'] );
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
        $name=sanitize_text_field($data['name']);
        $family=sanitize_text_field($data['family']);
        $stat=sanitize_text_field($data['stat']);
        $city=sanitize_text_field($data['city']);
        $address=sanitize_text_field($data['address']);
        $national_code=helpers::convertNumberToEnglish($data['national-code']);
        $postal_code=helpers::convertNumberToEnglish($data['postal-code']);
        $phone=helpers::convertNumberToEnglish($data['phone']);
        $mobile=helpers::convertNumberToEnglish($data['mobile']);
        $email=sanitize_email($data['email']);
        $data=[
            'name'=>$name,
            'family'=>$family,
            'stat'=>$stat,
            'city'=>$city,
            'address'=>$address,
            'national_code'=>$national_code,
            'postal_code'=>$postal_code,
            'phone'=>$phone,
            'mobile'=>$mobile,
            'email'=>$email,
        ];
        if (empty($name) || empty($family)){
            wp_send_json_error(['message'=>'نام و نام خانوادگی را وارد کنید' ]);
        }
        if (empty($stat) || empty($city)){
            wp_send_json_error(['message'=>'وارد کردن استان و شهر اجباری می‌باشد' ]);
        }
        if (empty($address)){
            wp_send_json_error(['message'=>'لطفا آدرس را وارد کنید' ]);
        }
        if (empty($national_code)){
            wp_send_json_error(['message'=>'کد ملی را وارد کنید' ]);
        }
        if (empty($postal_code)){
            wp_send_json_error(['message'=>'کد پستی را وارد کنید' ]);
        }
        if (empty($phone)){
            wp_send_json_error(['message'=>'شماره تلفن ثابت را وارد کنید' ]);
        }
        if (empty($mobile)){
            wp_send_json_error(['message'=>'شماره تلفن همراه را وارد کنید' ]);
        }
        if (empty($email)){
            wp_send_json_error(['message'=>'یک ایمیل معتبر وارد کنید' ]);
        }


        unset($data['_wpnonce']);
        unset($data['_wp_http_referer']);
        $_website_wizard['register-domain-hamyar']=$data;
        update_user_meta(get_current_user_id(),'_website_wizard',$_website_wizard);

        wp_send_json_success(['message'=>"اطلاعات شما ثبت شد. به زودی همکاران ما با شما تماس خواهند گرفت"] );
    }
}