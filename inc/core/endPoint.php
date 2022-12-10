<?php
namespace HamyarSaz\core;


class endPoint
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
    }

    public function define_hooks()
    {
        add_action( 'init', [$this, 'add_endpoint'] );

        add_filter( 'template_redirect', [$this, 'project_attachments_template'] );
        remove_action( 'admin_bar_menu', 'wp_admin_bar_wp_menu', 10 );
        add_action('admin_bar_menu',function (){
            remove_action( 'admin_bar_menu', 'wp_admin_bar_wp_menu', 10 );
        },0);

        add_action( 'admin_bar_menu', [$this,'wp_admin_bar_wp_menu'], 10 );

    }

    public function wp_admin_bar_wp_menu($wp_admin_bar){
        $wp_logo_menu_args = array(
            'id'    => 'wp-logo',
            'title' => '<span class="ab-icon" aria-hidden="true"></span><span style="padding-right: 5px">همیارساز</span>',
            'href'  => hamyar_saz_get_admin_url(),
        );
        $wp_admin_bar->add_node( $wp_logo_menu_args );
    }
    public function add_rewrite_rules($wp_rewrite)
    {
        $wp_rewrite->rules = array_merge(
            ['hamsaz\/(\w*\/)*paged\/(\d+)\/?$' => 'index.php?hamyar='.$matches[0].'&paged='.$matches[2]],
            $wp_rewrite->rules
        );
        $wp_rewrite->rules = array_merge(
            ['hamsaz\/(\w*\/)?$' => 'index.php?hamsaz='.$matches[0]],
            $wp_rewrite->rules
        );

    }

    public function add_endpoint()
    {
        add_rewrite_endpoint('hamsaz', EP_ROOT);
    }

    function add_query_vars($vars){
        $vars[] = "hamsaz";
        return $vars;
    }

    function project_attachments_template($templates = ""){
        global $wp_query;
        $query=get_query_var( 'hamsaz', false );
        if ( $query!==false) {
            if (empty($query)){
                $query='dashboard';
            }
           self::loadTemplate($query);
            die();
        }
    }

    public static function loadTemplate($endpoint=null){
        if ( !is_user_logged_in() ) {
            wp_redirect( home_url( '/wp-login.php' ) );
            exit;
        }
//fixme check permission if need some item. example if user paid or not
//        if ( !current_user_can( 'administrator' ) ) {
//            wp_die( 'شما دسترسی لازم برای دسترسی به این صفحه را ندارید' );
//        }

        $query_explode=explode('/',$endpoint);
        $query_explode=array_filter($query_explode);
        if (in_array('paged',$query_explode) && is_numeric(end($query_explode))){
            $key=array_search('paged',$query_explode);
            $paged=$query_explode[$key+1]??false;
            if (is_numeric($paged)){
                set_query_var('paged',$paged);
                unset($query_explode[$key+1]);
                unset($query_explode[$key]);
            }
            $endpoint=implode('/',$query_explode);
        }elseif (in_array('edit',$query_explode) && is_numeric(end($query_explode))){
            $key=array_search('edit',$query_explode);
            $id=$query_explode[$key+1]??false;
            if (is_numeric($id)){
                set_query_var('edit',$id);
                unset($query_explode[$key+1]);
            }
            $endpoint=implode('/',$query_explode);
        }

        set_query_var('hamsaz','hamsaz/'.$endpoint);
        $template_location=HAMYAR_SAZ_DIR.'inc/templates/'.$endpoint;

        $template_location=str_replace(['../','..\\','./','.\\'],'',$template_location);
        if (is_dir($template_location) && file_exists($template_location)){
            $template_location=$template_location.'/index';
        }
//        $proccess=preg_replace('/\/edit$/','/add',$proccess);
        $template_location=preg_replace('/\/edit$/','/add',$template_location);

        if (isset($_REQUEST['_wpnonce'])) {
            $proccess=str_replace('/inc/templates/','/inc/core/proccess/',$template_location);
            if (file_exists($proccess.'.php')){
                include_once $proccess.'.php';
            }
        }
        $template_location=$template_location.'.php';
        if (!file_exists($template_location)) {
            wp_safe_redirect( home_url( '/hamsaz/' ) );
        }


        include $template_location;

    }

}