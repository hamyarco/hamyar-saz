<?php
/**
 * Created by PhpStorm.
 * User: alireza azami (hamyar.co)
 * Date: 25.10.22
 * Time: 13:51
 */


namespace HamyarSaz\core;


class template
{
    protected static $_instance = null;
    protected $templates;


    public static function get_instance()
    {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function __construct()
    {
        $this->templates = array('hamyar-saz-shop.php' =>'صفحه فروشگاه همیار');
        $this->define_hooks();
    }

    public function define_hooks()
    {
        add_filter( 'theme_page_templates', array( $this, 'add_new_template' ) );
        add_filter( 'wp_insert_post_data', array( $this, 'register_project_templates' ) );
        add_filter( 'template_include', array( $this, 'view_project_template') );
    }

    public function add_new_template( $posts_templates ) {
        $posts_templates = array_merge( $posts_templates, $this->templates );
        return $posts_templates;
    }


    public function register_project_templates( $atts ) {

        // Create the key used for the themes cache
        $cache_key = 'page_templates-' . md5( get_theme_root() . '/' . get_stylesheet() );

        // Retrieve the cache list.
        // If it doesn't exist, or it's empty prepare an array
        $templates = wp_get_theme()->get_page_templates();
        if ( empty( $templates ) ) {
            $templates = array();
        }

        // New cache, therefore remove the old one
        wp_cache_delete( $cache_key , 'themes');

        // Now add our template to the list of templates by merging our templates
        // with the existing templates array from the cache.
        $templates = array_merge( $templates, $this->templates );

        // Add the modified cache to allow WordPress to pick it up for listing
        // available templates
        wp_cache_add( $cache_key, $templates, 'themes', 1800 );

        return $atts;

    }

    public function view_project_template( $template ) {

        global $post;

        // Return template if post is empty
        if ( ! $post ) {
            return $template;
        }

        // Return default template if we don't have a custom one defined
        if ( ! isset( $this->templates[get_post_meta( $post->ID, '_wp_page_template', true )] ) ) {
            return $template;
        }

        $file = HAMYAR_SAZ_DIR.'inc/templates/'. get_post_meta( $post->ID, '_wp_page_template', true );

        if ( file_exists( $file ) ) {
            return $file;
        } else {
            echo $file;
        }

        return $template;

    }

}