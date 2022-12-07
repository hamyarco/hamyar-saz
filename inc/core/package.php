<?php


namespace HamyarSaz\core;


class package
{
    protected static $_instance = null;
    protected $table='hamyar_saz_package';

    public static function get_instance() {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function __construct() {
        $this->define_hooks();
        $this->createTable();
    }

    public function define_hooks(){
    }

    /**
     * @return string
     */
    public function getTable()
    {
        global $wpdb;
        return $wpdb->prefix.$this->table;
    }

    public function createTable()
    {
        require_once ABSPATH.'wp-admin/includes/upgrade.php';
        global $wpdb;
        $charset_collate =  $wpdb->get_charset_collate();
        $table =$this->getTable();
        $query="
		CREATE TABLE IF NOT EXISTS $table (
		  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
		  `user_id` bigint(20) unsigned NOT NULL,
		  `domain` varchar(20) NOT NULL,
		  `status` varchar(20) default NULL,
          `whmcs_uid` bigint(20) unsigned NOT NULL,
          `site_token` varchar(500) default NULL,
		  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,
		  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,
		  `deleted_at` TIMESTAMP ,
		  PRIMARY KEY (id, user_id)
		  ) {$charset_collate};";
        dbDelta($query);
    }

    public function getPackages($user_id=null)
    {
        if (is_null($user_id)){
            $user_id=get_current_user_id();
        }
        global $wpdb;
        $table=$this->getTable();
        $query="SELECT * FROM $table WHERE user_id=$user_id";
        $result=$wpdb->get_results($query);
        return $result;
    }
}