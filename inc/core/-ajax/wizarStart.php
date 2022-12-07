<?php
/**
 * Created by PhpStorm.
 * User: alireza azami (hamyar.co)
 * Date: 26.10.22
 * Time: 14:52
 */


namespace HamyarSaz\core\ajax;


use HamyarSaz\core\ajax;
use HamyarSaz\core\helpers;

class wizarStart
{
    protected static $_instance = null;

    public static function get_instance() {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function __construct() {
        $this->define_hooks();
        selectProduct::get_instance();
    }

    public function define_hooks(){
        add_action( 'wp_ajax_hamyar_wizard_1', [$this, 'hamyarWizardStart'] );
    }

    public function hamyarWizardStart(){
        ajax::hasPermission();
        $_website_wizard=get_user_meta(get_current_user_id(),'_website_wizard',true);
        if (empty($_website_wizard)){
            $_website_wizard=[];
        }

        $data = $_POST;
        if ( ! wp_verify_nonce( $data['_wpnonce'] )) {
            wp_send_json_error(['message'=>'ورودی نامعتبر می‌باشد. لطفا صفحه را مجدد باز کرده و اقدام نمایید' ]);
        }
        $display_name=sanitize_text_field($data['display-name']);
        $username=str_replace(' ','_',sanitize_text_field($data['username']));
        $image=sanitize_text_field($data['image-uploader']);
        $phone=sanitize_text_field($data['phone']);
        $email=sanitize_text_field($data['email']);

        if (empty($username) || empty($display_name)){
            wp_send_json_error(['message'=>'نام کاربری و نام نمایشی نمی‌تواند خالی باشد' ]);
        }

        if (!isset($_website_wizard['start']) || !isset($_website_wizard['start']['username']) || $_website_wizard['start']['username']!=$username){
            if (get_page_by_path( $username, OBJECT, 'page')){
                wp_send_json_error(['message'=>'نام کاربری وارد شده تکراری می‌باشد. لطفا نام کاربری دیگری انتخاب نمایید' ]);
            }
        }

        $page_object=get_page_by_path( $_website_wizard['start']['username'], OBJECT, 'page');
        $page_data = array(
            'post_type'     => 'page',
            'post_title'    => $display_name,
            'post_content'  => '',
            'post_status'   => 'public',
            'post_author'   => get_current_user_id(),
            'post_name' => $username,
            'page_template'=>'hamyar-saz-shop.php'
        );
        if (empty($page_object)){
            $page_id = wp_insert_post($page_data);
        }else{
            $page_id=$page_object->ID;
            $page_data['ID']=$page_object->ID;
            wp_update_post($page_data);
        }

        if (!is_numeric($image)){
            $upload_id=helpers::saveImage($image);
        }else{
            $upload_id=$image;
        }

        $_website_wizard=get_user_meta(get_current_user_id(),'_website_wizard',true);
        if (empty($_website_wizard)){
            $_website_wizard=[];
        }

        $wizard_data=[
            'display-name'=>$display_name,
            'username'=>$username,
            'image'=>$upload_id,
            'phone'=>$phone,
            'email'=>$email,
            'page_id'=>$page_id,
        ];
        $_website_wizard['start']=$wizard_data;

        update_user_meta(get_current_user_id(),'_website_wizard',$_website_wizard);

        wp_send_json_success(['message'=>'اطلاعات با موفقیت ثبت شد','javascript'=>"hs_next_step('add-product')"] );
    }

}