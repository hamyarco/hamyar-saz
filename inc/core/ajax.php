<?php

namespace HamyarSaz\core;

class ajax{
    protected static $_instance = null;

    public static function get_instance() {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function __construct() {
        $this->autoloadAjax();
    }

    public function autoloadAjax(){
        if (isset($_REQUEST['class']) && file_exists(HAMYAR_SAZ_DIR.'inc/core/ajax/'.$_REQUEST['class'].'.php')){
            $class = 'HamyarSaz\core\ajax\\'.$_REQUEST['class'];
            add_action('wp_ajax_hamyar_saz',[$class,'ajax']);
            add_action('wp_ajax_nopriv_hamyar_saz',[$class,'ajax']);
        }

    }

    public function ajax(){
       wp_send_json(['message'=>'no action']);
    }

    public static function hasPermission()
    {
        return true; //fixme check permission if need some item. example if user paid or not
        if (!current_user_can('administrator')  ) {
            wp_send_json_error(['message'=>'شما اجازه دسترسی به این بخش را ندارید']);
        }
    }
    public static function nonceChecker(){
        if (!isset($_REQUEST['_nonce']) || !wp_verify_nonce($_REQUEST['_nonce'], 'hamyar-saz-public')) {
            wp_send_json_error(['message'=>'شما اجازه دسترسی به این بخش را ندارید']);
        }
    }
}