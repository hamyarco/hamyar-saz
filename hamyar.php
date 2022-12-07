<?php

/*
Plugin Name: همیار ساز
Plugin URI: https://hamyar.co
Description:
Author: hamyar team
Author URI:  https://hamyar.co
Version: 1.0
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: hamyar-saz
Domain Path: /hanguages
*/


defined('ABSPATH') || exit ("no access");



define('HAMYAR_SAZ_FILE', __FILE__);
define('HAMYAR_SAZ_DIR', plugin_dir_path(HAMYAR_SAZ_FILE));
define('HAMYAR_SAZ_URL', plugin_dir_url(HAMYAR_SAZ_FILE));
define('HAMYAR_SAZ_ASSETS_URL', HAMYAR_SAZ_URL.'assets/');
define('HAMYAR_SAZ_MATERIALIZE_URL', HAMYAR_SAZ_URL.'materialize/');
define('HAMYAR_SAZ_VER', '1.0.2');
define('HAMYAR_SAZ_AUTOLOAD', __DIR__.'/inc/vendor/autoload.php');

require_once HAMYAR_SAZ_AUTOLOAD;
//require_once HAMYAR_SAZ_DIR.'inc/main/global-functions.php';



\HamyarSaz\main::get_instance();