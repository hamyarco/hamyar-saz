<?php   defined('ABSPATH') || exit ("no access"); ?>
<?php \HamyarSaz\core\helpers::template( 'header',['title'=>'لیست محصولات']); ?>
    <div class="row" id="ecommerce-products">
        <link rel="stylesheet" type="text/css" href="<?php echo HAMYAR_SAZ_MATERIALIZE_URL ?>app-assets/css-rtl/pages/eCommerce-products-page.css">



<?php
$count=12;
$paged=get_query_var('paged') ? get_query_var('paged') : 1;
$offset = ($paged - 1) * $count;

$args = array(
    'post_type' => 'product',
    'paged' => $paged,
    'post_status' => ['publish','pending'],
    'offset' => $offset,
    'posts_per_page' =>$count
);

$loop = new WP_Query( $args );
if (isset($loop->posts) && count($loop->posts)>0){
    $hidden=true;
    foreach ($loop->posts as $post){
        $product=wc_get_product($post->ID);
        ?>
        <div class="col s6  m4 l3">
            <div class="card">
                <?php if($product->get_status()=='pending'): ?>
                    <div class="card-badge pending"><a class="white-text"> <b>بایگانی شده</b> </a></div>
                <?php elseif ($product->is_on_sale()): ?>
                    <div class="card-badge"><a class="white-text"> <b>فروش ویژه</b> </a></div>
                <?php endif; ?>
                <div class="card-image waves-effect waves-block waves-light">
                    <?php echo $product->get_image('woocommerce_thumbnail',['class'=>'activator','width'=>200]) ?>
                </div>
                <div class="card-content padding-5">
                    <span class="card-title">
                        <span class="text-ellipsis"> <?php echo $product->get_title(); ?> </span>
                        <span class="activator"><i class="material-icons">more_vert</i></span>
                    </span>

                        <h5 class="red-text  text-ellipsis">
                            <?php if($product->is_on_sale()): ?>
                                <?php echo number_format($product->get_sale_price()) ?><span class="grey-text lighten-2 mr-3 prise-text-style"><?php echo  number_format($product->get_regular_price()) ?></span>
                                <small><?php echo get_woocommerce_currency_symbol() ?></small>

                            <?php else: ?>
                                <?php echo  number_format($product->get_regular_price()) ?><small><?php echo get_woocommerce_currency_symbol() ?></small>
                            <?php endif; ?>
                        </h5>
                </div>
                <div class="card-reveal" style="display: none; transform: translateY(0%);">
                    <span class="card-title grey-text text-darken-4"><i class="material-icons right close-icon">close</i></span>
                    <ul class="">
                        <li><a class="col s12 btn mt-8 mb-8 waves-effect waves-light" href="<?php echo $product->get_permalink(); ?>"  target="_blank">مشاهده </a></li>
                        <li><a class="col s12 btn mb-8 waves-effect waves-light" href="/hamsaz/products/edit/<?php echo $product->get_id(); ?>/"  >ویرایش</a></li>
                        <li>
                            <form method="post">
                                <?php wp_nonce_field() ?>
                                <input type="hidden" name="product_id" value="<?php echo $product->get_id(); ?>">
                                <?php if ($product->get_status()=='publish'): ?>
                                    <input type="hidden" name="action" value="archvie" >
                                    <button type="submit" class="col s12 btn mb-8 waves-effect waves-light" >بایگانی</button>
                                <?php else: ?>
                                    <input type="hidden" name="action" value="unarchvie" >
                                    <input type="hidden" name="action" value="unarchvie" >
                                    <button type="submit" class="col s12 btn mb-8 waves-effect waves-light" >بازگردانی</button>
                                <?php endif; ?>
                            </form>
                        </li>

                    </ul>
                </div>
            </div>
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
<?php
    endif;
?>
    <div style="bottom: 20px; right: 10px;" class="fixed-action-btn"><a href="add/" class="btn-floating waves-effect waves-light gradient-45deg-purple-deep-orange"><i class="material-icons">add</i></a>
    </div>
<?php
    \HamyarSaz\core\helpers::template( 'footer'); ?>