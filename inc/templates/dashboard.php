<?php   defined('ABSPATH') || exit ("no access");
    $post_view=new Post_Views_Counter_Dashboard();
?>
<?php \HamyarSaz\core\helpers::template( 'header',['title'=>'داشبورد','direct_styles'=>[POST_VIEWS_COUNTER_URL . '/css/admin-dashboard.min.css',POST_VIEWS_COUNTER_URL . '/assets/microtip/microtip.min.css']]); ?>
<?php   wp_print_styles(['pvc-admin-dashboard','pvc-microtip']) ?>
    <div class="row users-list-wrapper" id="ecommerce-products">
        <?php echo \HamyarSaz\core\helpers::dashboardAllert() ?>
    <div class="col s12  m6 dashboard">
        <ul class="collapsible collapsible-accordion">
            <li class="active">
                <div class="collapsible-header" tabindex="0">
                    <i class="material-icons">dashboard</i>
                    مهمترین اطلاعیه ها                        <i class="material-icons">arrow_drop_down</i>
                </div>
                <div class="collapsible-body" style="display: block;">
                    <div class="items">
                            <a class="grey-text text-darken-2" href="<?php echo hamyar_saz_get_admin_url('/products/orders') ?>">
                                <i class="material-icons">shopping_basket</i>
                                <?php echo \HamyarSaz\core\helpers::countTodayOrders() ?>
                                سفارش جدید                             </a>
                            <a class="grey-text text-darken-2" href="<?php echo hamyar_saz_get_admin_url('/other/comments') ?>">
                                <i class="material-icons">mode_comment</i>
                                <?php echo \HamyarSaz\core\helpers::countTodayComments() ?>
                                دیدگاه جدید
                            </a>
                    </div>
                </div>
            </li>
        </ul>

    </div>
</div>
<div class="row">
    <div class="col s12  m6 dashboard">
        <?php
        $post_view->init_admin_dashboard();
        $post_view->dashboard_widget(); ?>
    </div>
</div>
<!-- /.row -->
    <script>
        const pvcArgs=<?php echo json_encode([
                                                  'ajaxURL'	=> admin_url( 'admin-ajax.php' ),
                                                  'nonce'		=> wp_create_nonce( 'pvc-dashboard-widget' ),
                                                  'nonceUser'	=> wp_create_nonce( 'pvc-dashboard-user-options' )
                                              ]) ?>;

    </script>
<?php \HamyarSaz\core\helpers::template( 'footer',['direct_scripts'=>[POST_VIEWS_COUNTER_URL . '/assets/chartjs/chart.min.js',POST_VIEWS_COUNTER_URL . '/js/admin-dashboard.js','script'=>'']]); ?>