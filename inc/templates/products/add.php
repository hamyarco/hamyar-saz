<?php   defined('ABSPATH') || exit ("no access"); ?>
<?php \HamyarSaz\core\helpers::template( 'header',['title'=>!empty($id)?'ویرایش محصول':'افزودن محصول']); ?>
<?php
if (isset($id) && !empty($id)){
    $product = wc_get_product( $id );
    if ( ! $product ) {
        wp_die('محصولی یافت نشد');
    }

    $arg = [
        'product_id'=>$product->get_id(),
        'title' =>$product->get_title(),
        'description' =>$product->get_description(),
        'price' =>$product->get_regular_price(),
        'sales_price' =>$product->get_sale_price(),
        'stock' =>$product->get_stock_quantity(),
        'categories'=>$product->get_category_ids(),
        'images'=>$product->get_gallery_image_ids(),
    ];
    array_unshift($arg['images'],$product->get_image_id());
}else{
    $arg=[];
}


$default_args = [
    'product_id'=>'',
    'title' =>'',
    'description' =>'',
    'price' =>'',
    'sales_price' =>'',
    'stock' =>'',
    'categories'=>[],
];

extract(hsaz_default_args($default_args,$arg));
if (empty($images)){
    $images=[];
}
array_walk($images,function (&$item){
    $item=(int)$item;
});
$images= array_unique($images);
?>
    <link rel="stylesheet" href="<?php echo HAMYAR_SAZ_MATERIALIZE_URL ?>app-assets/vendors/select2/select2-materialize.css" type="text/css">
    <div class="row " >
        <div class="col s12 m6 l4 push-m3 push-l4 ">
            <div id="validation" class="card card card-default scrollspy">
                <div class="card-content">
                    <form enctype="multipart/form-data" data-bitwarden-watching="1" method="post">
                        <?php wp_nonce_field() ?>
                        <input type="hidden" name="product_id" value="<?php echo $product_id ?>">
                        <div class="row hamsaz-uploader">
                            <label>
                                <input type="hidden" name="image-uploader" value="">
                                <div id="product-images">
                                    <?php foreach ($images as $img_id): ?>
                                        <span class="product-image">
                                            <span class="image-remover" onclick="image_remover(this)"> &#x2715 </span>
                                            <?php echo wp_get_attachment_image($img_id) ?>
                                            <input type="hidden" value="<?php echo $img_id ?>" name="product-images[]">
                                        </span>
                                    <?php endforeach; ?>
                                </div>
                                <!-- /#product_images -->
                                <div id="single-image"></div>
                                <div class="website-logo-wrapper mb-5">
                                    <input type="button" value="افزودن تصویر" class="upload-btn upload-multi-image">
                                    <input type="file">
                                </div>
                            </label>
                        </div>
                        <div class="row">
                            <div class="input-field col s12">
                                <input id="title" type="text" name="title" class="" required value="<?php echo $title; ?>">
                                <label for="title">عنوان</label>
                            </div>
                        </div>
                        <div class="row">
                            <span id="old-text" style="display: none"><?php echo $description; ?></span>
                            <div class="input-field col s12">
                                <div class="snow-container">
                                    <div class="compose-editor"></div>
                                    <div class="compose-quill-toolbar hidden" >
                                                <span class="ql-formats mr-0">
                                                    <button class="ql-bold"></button>
                                                    <button class="ql-link"></button>
                                                    <button class="ql-image"></button>
                                                </span>
                                    </div>
                                </div>
                                <input type="hidden" name="description">
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s12">
                                <input id="price" type="tel" name="price" class="" required value="<?php echo $price ?>">
                                <label for="price">قیمت اصلی(تومان)</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s12">
                                <input id="sales-price" type="tel" name="sales_price" class="" value="<?php echo $sales_price ?>" >
                                <label for="sales-price">قیمت فروش ویژه(اختیاری)</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s12">
                                <input id="stock" type="tel" name="stock" class="" value="<?php echo $stock ?>">
                                <label for="stock">موجودی انبار</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field">
                                <select class="select2 browser-default" multiple="multiple" name="categories[]">
                                    <?php
                                    $terms = get_terms( ['taxonomy'=>'product_cat','hide_empty' => false] );
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
<?php ob_start(); ?>
    <script>
        $(document).ready(function () {
            $(".select2").select2({
                dropdownAutoWidth: true,
                width: '100%',
                placeholder: "انتخاب دسته بندی",
                dir: "rtl",
                tags: true
            });
        });
        // Quill Editor
        // -------------------
        var composeTodoEditor = new Quill(".snow-container .compose-editor", {
            modules: {
                toolbar: ".compose-quill-toolbar"
            },
            placeholder: "توضیحات...",
            theme: "snow"
        });
        <?php if (!empty($description)): ?>
        var editor = document.getElementsByClassName('ql-editor')
        editor[0].innerHTML = document.querySelector('#old-text').innerHTML
        <?php endif; ?>
    </script>
<?php $script=ob_get_clean();

\HamyarSaz\core\helpers::template( 'footer',['script'=>$script]); ?>