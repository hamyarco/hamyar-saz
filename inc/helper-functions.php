<?php
use HamyarSaz\core\helpers;

function hsaz__($key,$default){
    return helpers::flatIsSet($key,$default);
}

function hsaz_e($key,$default=null){
    echo helpers::flatIsSet($key,$default);
}

function hsaz_head(){
    do_action('hamyar_saz_header');
    remove_all_actions('wp_head');
    add_action( 'wp_head', 'wp_enqueue_scripts', 1 );
    add_action( 'wp_head', 'wp_print_styles', 8 );
    add_action( 'wp_head', 'wp_print_head_scripts', 9 );
    wp_head();
}

function hsaz_footer(){
    do_action('hamyar_saz_footer');
    remove_all_actions('wp_footer');
    add_action( 'wp_footer', 'wp_enqueue_global_styles', 1 );
    add_action( 'wp_footer', 'wp_maybe_inline_styles', 1 ); // Run for late-loaded styles in the footer.
    add_action( 'wp_footer', 'wp_print_footer_scripts', 20 );
    wp_footer();

}
function hsaz_default_args($default_args,$args){
    foreach ( $default_args as $key => $value ) {
        if(!isset($args[$key])){
            $args[$key]= $value;
        }
    }
    return $args;
}


function hsaz_active_menu($current_menu_array='', $active_class='active',$parent=true){
    global $active_menu;
    if (empty($active_menu)){
        $active_menu=get_query_var('hamsaz');
    }
    if(!is_array($current_menu_array)){
        $current_menu_array=[$current_menu_array];
    }

    foreach ($current_menu_array as $current_menu){
        if(is_array($current_menu)){
            return;
        }
        $current_menu=trim($current_menu,'/');
        if ($active_menu==$current_menu){
            echo $active_class;
        }elseif($parent &&  strpos($active_menu,$current_menu)===0){
            echo $active_class;
        }
    }


}

function hamyar_saz_get_admin_url($url=''){
    return get_site_url(null,implode('/',['/hamsaz',trim($url,'/')]));
}

function hmyarsaz_set_error($message,$reset=true){
    if ($reset){
        $_POST['errors']=[];
    }
    $_POST['errors'][]=$message;
}