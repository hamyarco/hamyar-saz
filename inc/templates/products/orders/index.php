<?php   defined('ABSPATH') || exit ("no access"); ?>
<?php \HamyarSaz\core\helpers::template( 'header',['title'=>'سفارشات','body_id'=>'orders']); ?>
    <link rel="stylesheet" type="text/css" href="<?php echo HAMYAR_SAZ_MATERIALIZE_URL ?>app-assets/vendors/flag-icon/css/flag-icon.min.css">
    <link rel="stylesheet" href="<?php echo HAMYAR_SAZ_MATERIALIZE_URL ?>app-assets/vendors/select2/select2.min.css" type="text/css">
    <link rel="stylesheet" href="<?php echo HAMYAR_SAZ_MATERIALIZE_URL ?>app-assets/vendors/select2/select2-materialize.css" type="text/css">
    <link rel="stylesheet" type="text/css" href="<?php echo HAMYAR_SAZ_MATERIALIZE_URL ?>app-assets/css/pages/app-sidebar.css">
    <link rel="stylesheet" type="text/css" href="<?php echo HAMYAR_SAZ_MATERIALIZE_URL ?>app-assets/css/pages/app-todo.css">
<?php
$count=12;
$paged=get_query_var('paged') ? get_query_var('paged') : 1;
$offset = ($paged - 1) * $count;

$args = array(
    'post_type' => 'shop_order',
    'post_status' => array_keys(wc_get_order_statuses()),
    'paged' => $paged,
    'offset' => $offset,
    'posts_per_page' =>$count,
);

$loop = new WP_Query( $args );
?>


<div class="row">
    <div class="col s12">
        <div class="todo-overlay"></div>
        <div class="app-todo">
            <div class="content-area content-right">
                <div class="app-wrapper">
                    <div class="card card card-default scrollspy border-radius-6 fixed-width">
                        <div class="card-content p-0">
                            <ul class="collection todo-collection ps ps--active-y" style="max-height: 624px;">
                            <?php if (isset($loop->posts) && count($loop->posts)>0):?>
                                <?php     foreach ($loop->posts as $post) : $order=wc_get_order( $post->ID ); ?>
                                    <li class="collection-item todo-items">
                                        <div class="list-left">
                                            <label data-order-id="<?php echo $post->ID ?>">
                                                 <?php echo $post->ID ?>
                                            </label>
                                        </div>
                                        <div class="list-content">
                                            <div class="list-title-area">
                                                <div class="list-title"><?php echo wc_price( $order->get_total(), array( 'currency' => $order->get_currency() )); ?></div>
                                                <div class="list-date"><?php echo nl2br(date_i18n("Y/m/d (H:i)",strtotime($post->post_date))) ?> </div>
                                            </div>
                                        </div>
                                        <div class="list-right">
                                            <span class="badge grey lighten-0 border-radius-4" data-status="<?php echo $post->post_status ?>"><?php echo wc_get_order_status_name($post->post_status) ?></span>
                                        </div>
                                    </li>
                                <?php endforeach;else: ?>
                                    <li class="collection-item todo-items">
                                        <div class="list-content">
                                            <div class="list-title-area">
                                                <div class="list-title">متاسفانه سفارشی یافت نشد</div>
                                            </div>
                                        </div>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- todo compose sidebar -->
        <div class="todo-compose-sidebar">
            <div class="card quill-wrapper">
                <div class="card-content pt-0 pb-0">
                    <div class="card-header display-flex pb-2">
                        <h3 class="card-title todo-title-label">سفارش شماره ۱۲</h3>
                        <div class="close close-icon">
                            <i class="material-icons">close</i>
                        </div>
                    </div>
                    <div class="divider"></div>

                    <form class="edit-todo-item mt-2 mb-0" method="post">
                        <input type="hidden" name="order-id" value="">
                        <?php wp_nonce_field() ?>
                        <div class="input-field">
                            <h3 class="card-title"  data-type="order-items">آیتم ها</h3>
                            <div class="loader center-align">
                                <div class="preloader-wrapper small active">
                                    <div class="spinner-layer spinner-green-only">
                                        <div class="circle-clipper left">
                                            <div class="circle"></div>
                                        </div><div class="gap-patch">
                                            <div class="circle"></div>
                                        </div><div class="circle-clipper right">
                                            <div class="circle"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="divider"></div>

                        <div class="input-field">
                            <h3 class="card-title" data-type="order-factor">فاکتور</h3>
                            <div class="loader center-align">
                                <div class="preloader-wrapper small active">
                                    <div class="spinner-layer spinner-green-only">
                                        <div class="circle-clipper left">
                                            <div class="circle"></div>
                                        </div><div class="gap-patch">
                                            <div class="circle"></div>
                                        </div><div class="circle-clipper right">
                                            <div class="circle"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="divider"></div>

                        <div class="input-field">
                            <h3 class="card-title" data-type="user-details">اطلاعات کاربر</h3>
                            <div class="loader center-align">
                                <div class="preloader-wrapper small active">
                                    <div class="spinner-layer spinner-green-only">
                                        <div class="circle-clipper left">
                                            <div class="circle"></div>
                                        </div><div class="gap-patch">
                                            <div class="circle"></div>
                                        </div><div class="circle-clipper right">
                                            <div class="circle"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="divider"></div>
                        <div class="input-field">
                            <div class="display-flex justify-content-between">
                                <div class="pt-3 pr-3">
                                    وضعیت سفارش:
                                </div>
                                <select class="right status" name="order-status">
                                    <?php $order_status=wc_get_order_statuses(); ?>
                                    <?php foreach ($order_status as $key=>$value): ?>
                                        <option value="<?php echo $key ?>"><?php echo $value ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="input-field">
                            <div class="display-flex justify-content-between">
                                <div>
                                    تاریخ سفارش:
                                </div>
                                <div class="order-date"></div>
                            </div>
                        </div>
                        <div class="input-field">
                            <div class="display-flex justify-content-between">
                                <div data-type="order-payment">
                                    شیوه پرداخت:
                                </div>
                                <div class="loader center-align">
                                    <div class="preloader-wrapper small active">
                                        <div class="spinner-layer spinner-green-only">
                                            <div class="circle-clipper left">
                                                <div class="circle"></div>
                                            </div><div class="gap-patch">
                                                <div class="circle"></div>
                                            </div><div class="circle-clipper right">
                                                <div class="circle"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-action p-0 pt-5 right-align">
                            <button class="btn-small waves-effect waves-light update-todo">
                                <span>ذخیره</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div><!-- START RIGHT SIDEBAR NAV -->
    </div>
    <!-- /.col -->
</div>
<!-- /.row -->

<?php
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



\HamyarSaz\core\helpers::template( 'footer'); ?>