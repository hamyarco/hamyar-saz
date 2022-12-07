<?php
/**
 * Created by PhpStorm.
 * User: alireza azami (hamyar.co)
 * Date: 16.11.22
 * Time: 13:04
 */
namespace HamyarSaz\core\ajax;


use HamyarSaz\core\ajax;

class getOrder
{
    public function ajax()
    {
        ajax::nonceChecker();
        $order_id = $_REQUEST['order_id'];
        $order = wc_get_order($order_id);
        $order_data = $order->get_data();
        $order_data['full_address'] =implode(',',[$order->get_shipping_state().$order->get_shipping_address_1(),$order->get_shipping_city(),$order->get_shipping_postcode()]);
        $order_data['item_details']=[];
        foreach ($order->get_items() as $item){
            $order_data['item_details'][] = ['quantity'=>$item->get_quantity(),'name'=>$item->get_name(),'price'=> $item->get_total()];
        }
        wp_send_json($order_data);
    }
}