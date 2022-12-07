<?php defined('ABSPATH') || exit ("no access"); ?>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>تبریک فروشگاه</title>
    <?php
    wp_head(); ?>
</head>
<body <?php body_class( ['flex-center'] ); ?>>
<?php
$_website_wizard=get_user_meta(get_current_user_id(),'_website_wizard',true);
$username=$_website_wizard['start']['username'];
?>
<section id="hsw">
    <form enctype="multipart/form-data" action="" method="post">
        <span class="circle-loader"></span>
        <h1>مشاهده فروشگاه</h1>
        <p>
            ویدیوی تبریک برای ساخت فروشگاه
            <br>
شما محصولات خودتون رو اضافه کردین و در عمل فروشگاه شما آماده است.
            <br>
            برای مشاهده میتونین از لینک زیر فروشگاه خودتون رو مشاهده کنین...
            <br>
            <a href="<?php echo get_site_url(null,$username); ?>" target="_blank">مشاهده صفحه فروشگاه</a>
            <br>
            <br>
            فقط یادتون باشه که این صفحه هنوز در اختیار شما نیست و باید تا تکمیل فرایند با ما همراه باشین
        </p>
        <div class="select-step" >
            <div class="next-step" onclick="hs_next_step('select-domain')">ادامه</div>
            <div class="prev-step" onclick="hs_next_step('add-product')">مرحله قبل</div>
        </div>
    </form>
</section>

<?php
wp_footer(); ?>
</body>
</html>