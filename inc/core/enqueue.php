<?php
namespace HamyarSaz\core;

class enqueue{
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
        add_action('hamyar_saz_header', array($this, 'enqueue_files'));
//        add_action('hamyar_saz_footer', array($this, 'admin_enqueue_files'));
    }


    public function enqueue_files()
    {
        remove_all_actions('wp_enqueue_scripts');
        wp_enqueue_script(
            'hamyar-saz-plugin',
            HAMYAR_SAZ_ASSETS_URL.'public/plugins.js',
            [],
            HAMYAR_SAZ_VER,
            true
        );

        wp_enqueue_script(
            'hamyar-saz-public',
            HAMYAR_SAZ_ASSETS_URL.'public/final.min.js',
            ['hamyar-saz-plugin'],
            HAMYAR_SAZ_VER,
            true
        );

        wp_enqueue_style(
            'hamyar-saz-plugin',
            HAMYAR_SAZ_ASSETS_URL.'public/plugins.css',
            [],
            HAMYAR_SAZ_VER
        );
        wp_enqueue_style(
            'hamyar-saz-public',
            HAMYAR_SAZ_ASSETS_URL.'public/style.min.css',
            ['hamyar-saz-plugin'],
            HAMYAR_SAZ_VER
        );

        $public_localize=[
            '_nonce' => wp_create_nonce('hamyar-saz-public'),
            '_ajax_url'=>admin_url('admin-ajax.php'),
            '_home_url'=>home_url(),
            '_hamyar_saz_url'=>home_url('/hamyar/'),
            '_assets_url'=>HAMYAR_SAZ_ASSETS_URL
        ];

        $public_localize=apply_filters('hamyar_saz_public_localize_script',$public_localize);
        wp_localize_script(
            'hamyar-saz-public',
            'hamyar_saz_public',
            $public_localize
        );
    }

    public function admin_enqueue_files()
    {
        wp_enqueue_script(
            'hamyar-saz-admin',
            HAMYAR_SAZ_ASSETS_URL.'admin/final.min.js',
            ['jquery'],
            HAMYAR_SAZ_VER,
            true
        );
        wp_enqueue_style(
            'hamyar-saz-admin',
            HAMYAR_SAZ_ASSETS_URL.'admin/style.min.css',
            [],
            HAMYAR_SAZ_VER
        );
        $admin_localize=['_nonce' => wp_create_nonce('hamyar-saz-admin'),'_ajax_url'=>admin_url('wp-ajax.php')];
        $admin_localize=apply_filters('hamyar_saz_admin_localize_script',$admin_localize);
        wp_localize_script(
            'hamyar-saz-admin',
            'hamyar_saz_admin',
            $admin_localize
        );
    }

}