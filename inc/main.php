<?php
/**
 * Created by PhpStorm.
 * User: alireza azami (hamyar.co)
 * Date: 12.10.22
 * Time: 15:27
 */


namespace HamyarSaz;

use HamyarSaz\core\ajax;
use HamyarSaz\core\endPoint;
use HamyarSaz\core\enqueue;
use HamyarSaz\core\template;

class main
{
    protected static $_instance = null;

    public static function get_instance()
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    public function __construct()
    {
        $this->define_hooks();
        $this->run();
    }

    public function define_hooks()
    {
        register_activation_hook(HAMYAR_SAZ_FILE, [$this, 'activation_hook']);
        register_deactivation_hook(HAMYAR_SAZ_FILE, [$this, 'deactivation_hook']);
        add_action('plugins_loaded', array($this, 'localization'));
    }


    public function localization()
    {
        load_plugin_textdomain('hamyar-saz', false, basename(HAMYAR_SAZ_DIR).'/languages');
    }

    public function run()
    {
        include_once HAMYAR_SAZ_DIR.'inc/helper-functions.php';
        endPoint::get_instance();
        enqueue::get_instance();
        ajax::get_instance();
        template::get_instance();
//        module_loader::get_instance();
//        admin_menu::get_instance();
//        cron::get_instance();
    }


    public function activation_hook()
    {
        update_option( 'woocommerce_currency' ,'IRT');
        update_option( 'woocommerce_currency_pos' ,'right');
//        $this->create_support_user();
//        log::create_table();
    }

    public function deactivation_hook()
    {
//        $this->delete_support_user();
    }


}
