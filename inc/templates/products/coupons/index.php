<?php   defined('ABSPATH') || exit ("no access"); ?>
<?php \HamyarSaz\core\helpers::template( 'header',['title'=>'کدهای تخفیف']); ?>
    <div class="row users-list-wrapper" id="ecommerce-products">


<?php
$count=12;
$paged=get_query_var('paged') ? get_query_var('paged') : 1;
$offset = ($paged - 1) * $count;

$args = array(
    'post_type' => 'shop_coupon',
    'paged' => $paged,
    'post_status' => ['publish'],
    'offset' => $offset,
    'posts_per_page' =>$count
);

$loop = new WP_Query( $args );
if (isset($loop->posts) && count($loop->posts)>0){
    $hidden=true;
    global $woocommerce;
    foreach ($loop->posts as $post){
        $coupon=wc_get_coupon_code_by_id( $post->ID );
        $coupon_code = new WC_Coupon($coupon);
        ?>
        <div class="col s6  m4 l3 coupon">
            <ul class="collapsible collapsible-accordion">
                <li>
                    <div class="collapsible-header" tabindex="0">
                        <i class="material-icons">account_balance_wallet</i>
                        <?php printf('%s <small>%s</small>',  number_format($coupon_code->get_amount()),($coupon_code->get_discount_type()!=='percent'?get_woocommerce_currency_symbol():'درصد')); ?>
                        <i class="material-icons">arrow_drop_down</i>
                    </div>
                    <div class="collapsible-body">
                        <div class="items">
                            <span onclick="copyToClipboard('<?php echo $coupon_code->get_code() ?>')">
                                <i class="material-icons">content_copy</i>
                                <?php echo $coupon_code->get_code(); ?>
                            </span>
                            <span class="text-ellipsis display-flex">
                               <i class="material-icons">timelapse</i>
                                <?php $limit_count=$coupon_code->get_usage_limit(); ?>
                                <?php echo $coupon_code->get_usage_count() ?> از <?php echo $limit_count==0?'نامحدود': $limit_count ?>
                            </span>
                            <span class="text-ellipsis display-flex">
                            <i class="material-icons">local_mall</i>
                            <?php $products=$coupon_code->get_product_ids(); ?>
                                <?php echo empty($products)?'همه محصولات':get_the_title($products[0])  ?>
                        </span>
                        </div>
                        <div class=" action">
                            <a href="/hamsaz/products/coupons/edit/<?php echo $coupon_code->get_id(); ?>/">ویرایش</a>
                            <form method="post">
                                <?php wp_nonce_field() ?>
                                <input type="hidden" name="coupon_id" value="<?php echo $coupon_code->get_id(); ?>">
                                <?php if ($coupon_code->get_status()=='publish'): ?>
                                    <input type="hidden" name="action" value="archvie" >
                                    <button type="submit" >بایگانی</button>
                                <?php else: ?>
                                    <input type="hidden" name="action" value="unarchvie" >
                                    <button type="submit" >بازگردانی</button>
                                <?php endif; ?>
                            </form>
                        </div>
                    </div>
                </li>
            </ul>

        </div>
        <?php
    }
}else{
    $hidden=false;
}
$page_loop= ceil($loop->found_posts/$count) ;
if ( $loop->found_posts > $count ):
    ?>
    <div class="col s12">
        <ul class="pagination center">
            <?php if ($paged==1): ?>
                <li class="disabled">
                    <a href="#!">
                        <i class="material-icons">chevron_left</i>
                    </a>
                </li>
            <?php else: ?>
                <li>
                    <a href="<?php echo home_url(get_query_var('hamsaz')).'/paged/1/'; ?>">
                        <i class="material-icons">chevron_left</i>
                    </a>
                </li>
            <?php endif; ?>
            <?php for($i=1 ; $i <= $page_loop;$i++): ?>

                <li class="<?php echo ($i==$paged)?'active':'' ?>"><a href="<?php echo home_url(get_query_var('hamsaz')).'/paged/'.$i; ?>"><?php echo $i ?></a>
                </li>
            <?php endfor; ?>
            <?php if ($paged==$page_loop): ?>
                <li class="disabled">
                    <a href="#!">
                        <i class="material-icons">chevron_right</i>
                    </a>
                </li>
            <?php else: ?>
                <li>
                    <a href="<?php echo home_url(get_query_var('hamsaz')).'/paged/'.$page_loop; ?>">
                        <i class="material-icons">chevron_right</i>
                    </a>
                </li>
            <?php endif; ?>
        </ul>
    </div>
    </div>

<?php endif;

?>
<div style="bottom: 20px; right: 10px;" class="fixed-action-btn"><a href="add/" class="btn-floating waves-effect waves-light gradient-45deg-purple-deep-orange"><i class="material-icons">add</i></a>
</div>
<?php

\HamyarSaz\core\helpers::template( 'footer', ['script'=>$script
                                   ] ); ?>