<?php   defined('ABSPATH') || exit ("no access"); ?>
<?php \HamyarSaz\core\helpers::template( 'header',['title'=>'شروع','direct_styles'=>[POST_VIEWS_COUNTER_URL . '/css/admin-dashboard.min.css',POST_VIEWS_COUNTER_URL . '/assets/microtip/microtip.min.css']]); ?>
<?php

if (!isset($id)){
    $arg=[];
}
$default_args = [
    'site_id'=>'',
    'title' =>'',
    'category' =>[],
    'amount'=>'',
    'count'=>'',
    'usable_product'=>''
];
extract(hsaz_default_args($default_args,$arg));
?>

    <link rel="stylesheet" href="<?php echo HAMYAR_SAZ_MATERIALIZE_URL ?>app-assets/vendors/select2/select2-materialize.css" type="text/css">
    <div class="row " >
        <div class="col s12 m8 l6 push-m2 push-l3 ">
            <?php if (isset($_POST['errors'])): foreach ($_POST['errors'] as $error): ?>
                <div class="card-alert card red">
                    <div class="card-content white-text">
                        <p><?php echo $error ?></p>
                    </div>
                    <button type="button" class="close white-text mt-1" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
            <?php endforeach;endif; ?>
            <div id="validation" class="card card card-default scrollspy">
                <div class="card-content">
                    <form enctype="multipart/form-data" data-bitwarden-watching="1" method="post">
                        <?php wp_nonce_field() ?>
                        <input type="hidden" name="site_id" value="<?php echo $site_id ?>">
                        <div class="row">
                            <div class="input-field col s12">
                                <input id="title" type="text" name="title" class="" required value="<?php echo $title; ?>">
                                <label for="title">عنوان وبسایت</label>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <label class="ml-3 small">دسته بندی </label>
                            <div class="input-field pl-3 pr-3 mt-0">
                                <select class="select2 browser-default" name="category">
                                    <?php
                                    $terms = get_terms( ['taxonomy'=>'category','hide_empty' => false] );
                                    foreach ( $terms as $term ) {
                                        $selected='';
                                        foreach ($categories as $category){
                                            if ($category == $term->term_id){
                                                $selected='selected';
                                            }
                                        }
                                        printf('<option value="%s" %s>%s</option>', $term->term_id,$selected, $term->name);
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="input-field col s12">
                                <button class="btn cyan waves-effect waves-light right" type="submit" name="action"><?php echo !empty($id)?'ویرایش':'افزودن' ?>
                                    <i class="material-icons right">send</i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

<?php \HamyarSaz\core\helpers::template( 'footer',['vendor'=>['js/scripts/ui-alerts.js']]); ?>