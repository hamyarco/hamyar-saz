<?php
namespace HamyarSaz\core\ajax;

use HamyarSaz\core\helpers;
use \HamyarSaz\core\ajax;


class selectProduct{
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
        add_action( 'wp_ajax_hamyar_product', [$this, 'hamyarProduct'] );
        add_action( 'wp_ajax_hamyar_product_edit', [$this, 'hamyarProductEdit'] );
    }

    public function hamyarProductEdit(){
        ajax::hasPermission();

        $product_id = $_POST['product_id']??0;
        if (empty($product_id)){
            wp_send_json_error(['message'=>'محصول مورد نظر یافت نشد']);
        }
        $product = wc_get_product($product_id);
        if (empty($product)){
            wp_send_json_error(['message'=>'محصول مورد نظر یافت نشد']);
        }
        global $wpdb;
        $author_id= $wpdb->get_var( $wpdb->prepare("SELECT post_author FROM {$wpdb->posts} WHERE ID = %d",$product_id ));

        if ($author_id != get_current_user_id()){
            wp_send_json_error(['message'=>'شما دسترسی لازم برای این کار را ندارید']);
        }
        $title=$product->get_title();
        $description=$product->get_description();

        $regular_price=$product->get_regular_price();
        $sale_price=$product->get_sale_price();
        $stock_quantity=$product->get_stock_quantity();
        $manage_stock=$product->get_manage_stock();
        if (!$manage_stock){
            $stock_quantity='';
        }

        $images=$product->get_gallery_image_ids();
        array_unshift($images,$product->get_image_id());
        $image_urls=[];
        foreach ($images as $image_id){
            if (empty($image_id)) continue;
            $image_url=wp_get_attachment_image_url($image_id,'full');
            $image_urls[$image_id]=$image_url;
        }

        wp_send_json_success([
                                 'name'=>$title,
                                 'description'=>$description,
                                 'price'=>$regular_price,
                                 'sale_price'=>$sale_price,
                                 'stock'=>$stock_quantity,
                                 'images'=>$image_urls,
                                 'product_id'=>$product_id,
                             ]);
    }


    public function hamyarProduct(){
        ajax::hasPermission();

        $_website_wizard=get_user_meta(get_current_user_id(),'_website_wizard',true);
        if (empty($_website_wizard)){
            wp_send_json_error(['message'=>'نقص در اطلاعات','javascript'=>"hs_next_step('start')"] );
        }

        $data = $_POST;
        if ( ! wp_verify_nonce( $data['_wpnonce'] )) {
            wp_send_json_error(['message'=>'ورودی نامعتبر می‌باشد. لطفا صفحه را مجدد باز کرده و اقدام نمایید' ]);
        }
        $product_id=(int)sanitize_text_field($data['product_id']);
        $product_image=sanitize_text_field($data['image-uploader']);
        xdebug_break();
        $product_images=$data['product-images']??[];
        if (!empty($product_image)){
            $product_images[]=$product_image;
        }
        $upload_id=[];
        foreach ($product_images as $image){
            if (is_numeric($image)) {
                $upload_id[] = $image;
                continue;
            }
            $new_image=helpers::saveImage($image);
            if (is_numeric($new_image)){
                $upload_id[]=$new_image;
            }
        }

        $name=sanitize_text_field($data['name']);
        $description=sanitize_textarea_field($data['description']);
        $price=(int)sanitize_text_field($data['price']);
        $sales_price=(int)sanitize_text_field($data['sales_price']);
        xdebug_break();
        $stock='';
        if (isset($data['stock'])){
            if ($data['stock']!==''){
                $stock=(int)sanitize_text_field($data['stock']);
            }
        }
//        $category=sanitize_text_field($data['category']); //fixme add category selector

        if (!empty($product_id)){
            $product=wc_get_product($product_id);
            if (empty($product) || is_wp_error($product)){
                wp_send_json_error(['message'=>'محصول مورد نظر یافت نشد' ]);
            }
        }else{
            $product= new \WC_Product();
        }
        $product->set_name($name);
        $product->set_description($description);
        $product->set_regular_price($price);
        if (!empty($sales_price)){
            $product->set_sale_price($sales_price);
        }
        foreach ($upload_id as $key => $image_id){
            if ($key==0){
                $product->set_image_id($image_id);
            }
            $product->set_gallery_image_ids($image_id);
        }
        if ($stock===''){
            $product->set_manage_stock(false);
            $product->set_stock_quantity( '' );

        }else{
            $product->set_manage_stock(true);
            $product->set_stock_quantity($stock);
        }


        $_website_wizard['add-product']=[];
        update_user_meta(get_current_user_id(),'_website_wizard',$_website_wizard);
        $product->save();
        wp_send_json_success(['message'=>'محصول با موفقیت اضافه شد','javascript'=>'window.location.reload()'] );
    }
}