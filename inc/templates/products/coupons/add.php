<?php   defined('ABSPATH') || exit ("no access"); ?>
<?php \HamyarSaz\core\helpers::template( 'header',['title'=>!empty($id)?'ویرایش کوپن':'افزودن کوپن']); ?>
<?php
if (isset($id) && !empty($id)){
    $coupon_id=(int)sanitize_text_field($id);
    $coupon=wc_get_coupon_code_by_id( $coupon_id );
    if (!$coupon) wp_die('کپن یافت نشد');;

    $coupon_code = new WC_Coupon($coupon);

    $arg = [
        'post_id'=>$id,
        'title' =>$coupon_code->get_code(),
        'description' =>$coupon_code->get_description(),
        'amount'=>$coupon_code->get_amount(),
        'count'=>$coupon_code->get_usage_limit(),
        'usable_product'=>$coupon_code->get_product_ids()
    ];
}else{
    $arg=[];
}


$default_args = [
    'post_id'=>'',
    'title' =>'',
    'description' =>'',
    'amount'=>'',
    'count'=>'',
    'usable_product'=>''
];
extract(hsaz_default_args($default_args,$arg));
?>
    <link rel="stylesheet" href="<?php echo HAMYAR_SAZ_MATERIALIZE_URL ?>app-assets/vendors/select2/select2-materialize.css" type="text/css">
    <div class="row " >
        <div class="col s12 m6 l4 push-m3 push-l4 ">
            <div id="validation" class="card card card-default scrollspy">
                <div class="card-content">
                    <form enctype="multipart/form-data" data-bitwarden-watching="1" method="post">
                        <?php wp_nonce_field() ?>
                        <input type="hidden" name="coupon_id" value="<?php echo $post_id ?>">
                        <div class="row">
                            <div class="input-field col s12">
                                <input id="title" type="text" name="title" class="" required value="<?php echo $title; ?>">
                                <label for="title">کد تخفیف</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s12">
                                <textarea name="description" id="coupon-description" class="materialize-textarea" required><?php echo $description; ?></textarea>
                                <label for="coupon-description">توضیحات</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s12">
                                <input type="number" name="amount" id="coupon-amount" class="materialize-textarea" required value="<?php echo $amount; ?>">
                                <label for="coupon-amount">میزان تخفیف(تومان)</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s12">
                                <input type="number" name="count" id="coupon-count" class="materialize-textarea" required value="<?php echo empty($count) ? 10:$count; ?>">
                                <label for="coupon-count">تعداد قابل استفاده</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field">
                                <select class="select2 browser-default" name="usable_product">
                                    <?php
                                    $products = wc_get_products(['status'=>'publishe']);
                                    foreach ( $products as $product ) {
                                        $selected='';
                                        foreach ($usable_product as $u_product){
                                            if ($u_product == $product->get_id()){
                                                $selected='selected';
                                            }
                                        }
                                        printf('<option value="%s" %s>%s</option>', $product->get_id(),$selected, $product->get_title());
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
<?php ob_start(); ?>
    <script>
        $(document).ready(function () {
            $(".select2").select2({
                dropdownAutoWidth: true,
                width: '100%',
                placeholder: "انتخاب محصول",
                dir: "rtl",
                allowClear: true
            });
            <?php if (empty($selected)): ?>
            $(".select2").val('').trigger('change')
            <?php endif; ?>
        });


    </script>
<?php $script=ob_get_clean();

\HamyarSaz\core\helpers::template( 'footer',['script'=>$script]); ?>