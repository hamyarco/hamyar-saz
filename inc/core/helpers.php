<?php
/**
 * Created by PhpStorm.
 * User: alireza azami (hamyar.co)
 * Date: 17.10.22
 * Time: 16:25
 */


namespace HamyarSaz\core;


class helpers
{
    public static function saveImage($image_base64){
        require_once( ABSPATH . '/wp-admin/includes/file.php' );
        if (empty($image_base64)) {
            return false;
        }
        $image_base64 = explode(',', $image_base64);
        $image_type = str_replace(['data:image/', ';', 'base64',], ['', '', '',], $image_base64[0]);
        if ($image_type!=='png') {
            return wp_send_json_error(['message'=>'فرمت تصویر باید png باشد' ]);
        }
        if(!file_exists(WP_CONTENT_DIR.'/uploads/tmp/')){
            wp_mkdir_p(WP_CONTENT_DIR.'/uploads/tmp/');
        }

        $temp_path=\wp_tempnam('',WP_CONTENT_DIR.'/uploads/tmp/');
        $new_path=str_replace('.tmp', '.png', $temp_path);
        rename($temp_path,$new_path);

        file_put_contents($new_path, base64_decode($image_base64[1]));

        $final_file['name']=basename($new_path);
        $final_file['tmp_name']=$new_path;
        $final_file['error']=false;
        $final_file['size']=filesize($new_path);

        $upload_id=self::upload_picture($final_file);
        if (is_wp_error($upload_id)) {
            return wp_send_json_error(['message'=>$upload_id->get_error_message() ]);
        }
        return $upload_id;
    }

    public static function validateImages($image_base64){
        $image_base64 = explode(',', $image_base64);
        $image_type = str_replace(['data:image/', ';', 'base64',], ['', '', '',], $image_base64[0]);
        if ($image_type!=='png') {
            return response()->api('error','only jpg image accepted',200);
        }
        return true;
    }

    public static function upload_picture( $profilepicture) {
        $wordpress_upload_dir = wp_upload_dir();
        $i = 1; // number of tries when the file with the same name is already exists
        $profilepicture['name'] = str_replace( ' ', '_', $profilepicture['name'] );
        $new_file_path          = $wordpress_upload_dir['path'] . '/' . $profilepicture['name'];
        $new_file_mime          = mime_content_type( $profilepicture['tmp_name'] );

        if ( empty( $profilepicture ) ) {
            return 'هیچ تصویری دریافت نشد';
        }

        if ($profilepicture['error'] ) {
            return $profilepicture['error'];
        }


        if ($profilepicture['size'] > 1024000 ) {
            return 'حداکثر حجم مجاز برای این تصویر ۱ مگابایت می‌باشد.';
        }

        if ( ! in_array( $new_file_mime, [ 'png' => 'image/png', 'jpg|jpeg|jpe' => 'image/jpeg' ] ) ) {
            return 'نوع این فایل مجاز نمی‌باشد. فقط فایل هایی با پسوند jpg یا png مجاز می‌باشد.';
        }

        while ( file_exists( $new_file_path ) ) {
            $i ++;
            $new_file_path = $wordpress_upload_dir['path'] . '/' . $i . '_' . $profilepicture['name'];
        }

        if ( rename( $profilepicture['tmp_name'], $new_file_path ) ) {
            $upload_id = wp_insert_attachment( array(
                                                   'guid'           => $new_file_path,
                                                   'post_mime_type' => $new_file_mime,
                                                   'post_title'     => preg_replace( '/\.[^.]+$/', '', $profilepicture['name'] ),
                                                   'post_content'   => '',
                                                   'post_status'    => 'inherit'
                                               ), $new_file_path );

            // wp_generate_attachment_metadata() won't work if you do not include this file
            require_once( ABSPATH . '/wp-admin/includes/image.php' );

            // Generate and save the attachment metas into the database
            wp_update_attachment_metadata( $upload_id, wp_generate_attachment_metadata( $upload_id, $new_file_path ) );

            return $upload_id;
        }
        return new \WP_Error('upload_error', 'خطایی در آپلود تصویر رخ داده است.');
    }

    public static function getWizardMeta($step,$keys=[])
    {
        $_website_wizard=get_user_meta(get_current_user_id(),'_website_wizard',true);

        $step=$_website_wizard[$step]??[];
        foreach ($keys as $key){
            if (!isset($step[$key])) {
                $step[$key] = '';
            }
        }
        return $step;
    }

    public static function convertNumberToEnglish( $string ) {
        $persian_num = array( '۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹' );
        $latin_num   = range( 0, 9 );
        $string=str_replace(['٤', '٥', '٦','٨'],['4','5','6','8'],$string);
        $string      = str_replace( $persian_num,$latin_num,  $string );
        return $string;
    }

    public static function template($template,$arg=[]){
        $template=HAMYAR_SAZ_DIR.'inc/template-helpers/'.$template.'.php';
        if (!file_exists($template)) {
            wp_die( 'template not found:'.$template );
        }
        require $template;
    }

    public static function flatIsSet($key,$default=null){
        return isset( $key ) ? $key : $default;
    }

    public static function isConfigedBank(){
        $bacs_settings=get_option( 'woocommerce_bacs_settings', ['enabled'=>'no','title'=>'','description'=>''] );
        return $bacs_settings['enabled']==='yes';
    }

    public static function countPublishedProducts(){
        global $wpdb;
        return $wpdb->get_var('SELECT COUNT(*) FROM '.$wpdb->prefix.'posts WHERE post_type="product" AND post_status="publish"');
    }

    public static function countPublishedPosts(){
        global $wpdb;
        return $wpdb->get_var('SELECT COUNT(*) FROM '.$wpdb->prefix.'posts WHERE post_type="post" AND post_status="publish"');
    }

    public static function countTodayOrders(){
        global $wpdb;
        return $wpdb->get_var('SELECT COUNT(*) FROM '.$wpdb->prefix.'posts WHERE post_type="shop_order" AND post_status in ("wc-pending","wc-on-hold") AND post_date > DATE_SUB(NOW(), INTERVAL 1 DAY)');
    }

    public static function countTodayComments(){
        global $wpdb;
        return $wpdb->get_var('SELECT COUNT(*) FROM '.$wpdb->prefix.'comments WHERE comment_approved="0" AND comment_date > DATE_SUB(NOW(), INTERVAL 1 DAY)');
    }

    public static function dashboardAllert(){
        if (!self::isConfigedBank()){
            $text='برای دریافت پرداخت ها باید درگاه بانکی را تنظیم کنید.';
            $link=hamyar_saz_get_admin_url('/settings/payment/');
        }elseif(self::countPublishedProducts()==0){
            $text='شما هیچ محصولی فعالی ندارید. لطفا یک محصول تعریف کنید.';
            $link=hamyar_saz_get_admin_url('/products/add/');
        }
        if(!empty($text)){
            echo '<div class="col s12 strong">
            <a href="'.$link.'" class="card-alert card red lighten-5 display-block">
                <div class="card-content red-text">
                    <p>'.$text.'</p>
                </div>
            </a>
        </div>';
        }
    }
}

