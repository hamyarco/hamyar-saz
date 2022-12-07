<?php defined('ABSPATH') || exit ("no access"); ?>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <?php
    wp_head(); ?>
</head>
<body <?php body_class( ['flex-center'] ); ?>>
<main class="main-body">
    <section class="products--archive">
<?php
$args = array(
    'post_type' => 'product',
    'posts_per_page' => -1,
    'author' => get_current_user_id(),
);
$loop = new WP_Query( $args );

if (isset($loop->posts) && count($loop->posts)>0){
    $hidden=true;
    foreach ($loop->posts as $post){
        $product=wc_get_product($post->ID);
        ?>
                <section class="product-single" >
                    <a href="<?php echo $product->get_permalink(); ?>" target="_blank">
                        <?php echo $product->get_image('woocommerce_thumbnail') ?>
                        <h2><?php echo $product->get_title(); ?></h2>
                        <div class="price">
                            <?php echo $product->get_price_html(); ?>
                        </div>
                    </a>
                    <span class="edit" onclick="edit_this_product(<?php echo $product->get_id(); ?>)"> ویرایش این محصول </span>
                </section>
        <?php
    }
}else{
    $hidden=false;
}

?>
    </section>
    <div class="product--add <?php echo $hidden?'':'hidden'; ?>" onclick="show_add_product_form()">افزودن محصول جدید</div>
    <div class="select-step <?php echo $hidden?'':'hidden'; ?>" >
        <div class="next-step <?php echo $hidden?'':'disabled'; ?>" onclick="hs_next_step('product-ready', <?php echo $hidden?0:1; ?>)">مرحله بعد</div>
        <div class="prev-step" onclick="hs_next_step('start')">مرحله قبل</div>
    </div>
</main>

<section id="hsw" class="<?php echo $hidden?'hidden':''; ?>">
    <form enctype="multipart/form-data" action="" method="post">
        <span class="close <?php echo $hidden?'':'hidden'; ?>" onclick="hidden_add_product()">&#x2715;</span>
        <!-- /.close -->
        <span class="circle-loader"></span>
        <?php
        wp_nonce_field() ?>
        <input type="hidden" name="action" value="hamyar_product">
        <input type="hidden" name="product_id">
        <h1>افزودن محصول جدید</h1>
        <label>
            <input type="hidden" name="image-uploader" value="">
            <div id="product-images"></div>
            <!-- /#product_images -->
            <div id="single-image"></div>
            <div class="website-logo-wrapper">
                <input type="button" value="افزودن تصویر" class="upload-btn upload-multi-image">
                <input type="file"/>
            </div>
        </label>

        <label> نام*
            <input type="text" placeholder="نام محصول شما" name="name" required>
        </label>
        <label>
            توضحیات*
            <textarea name="description" cols="30" rows="5" required placeholder="مشخصات محصول را وارد کنید"></textarea>
        </label>

        <label>
            قیمت اصلی(تومان)
            <input type="tel" dir="ltr" name="price">
            <span class="description">قیمت اصلی محصول را وارد کنید</span>
        </label>
        <label>
            قیمت فروش ویژه(اختیاری)
            <input type="tel" dir="ltr" name="sales_price">
            <span class="description">قیمت محصول پس از تخفیف را وارد کنید</span>
        </label>
        <label>
            <input type="button" onclick="toogle_elements()" value="موارد بیشتر">
        </label>

        <label class="toogle-me">
            موجودی انبار(اختیاری)
            <input type="tel" dir="ltr" name="stock">
            <span class="description">در صورتی که محصول شما محدودیت موجودی دارد وارد کنید و اگر تمام شده ۰ وارد کنید</span>
        </label>

        <label class="toogle-me">
            دسته بندی (اختیاری)
            <input type="text" dir="ltr" name="category">
            <span class="description">دسته بندی این محصول را وارد نمایید.</span>
        </label>
        <input type="submit" value="ذخیره و ادامه">
    </form>
</section>

<?php
wp_footer(); ?>
</body>
</html>