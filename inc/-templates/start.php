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
<body <?php body_class(['flex-center']); ?>>
<?php
$step1=\HamyarSaz\core\helpers::getWizardMeta('start',[ 'display-name', 'username', 'image', 'phone', 'email']);

?>

<section id="hsw">


    <form  enctype="multipart/form-data" action="" method="post" >
        <?php wp_nonce_field() ?>
        <input type="hidden" name="action" value="hamyar_wizard_1">
        <h1>اطلاعات جهت نمایش در وبسایت</h1>

        <span class="circle-loader"></span>
        <label> نام نمایشی*
            <input type="text" placeholder="همیار آکادمی" name="display-name" required value="<?php echo $step1['display-name'];  ?>">
        </label>
        <label>
            نام کاربری*
            <input type="text" placeholder="hamyarco" dir="ltr" name="username" required  value="<?php echo $step1['username'];  ?>">
            <span class="description"> مثلا نام پیج اینستاگرام کاری خود را وارد کنید </span>
        </label>
        <label>
        <input type="hidden" name="image-uploader" value="<?php echo $step1['image'] ?>">
            <div id="website-logo">
                <?php if (!empty($step1['image'])) echo wp_get_attachment_image($step1['image'],[200,200],false,['class'=>'websie-logo-img']) ?>
            </div>
            <div class="website-logo-wrapper">
                <input type="button" value="انتخاب لگو سایت (اختیاری)" class="upload-btn upload-image">
                <input type="file"/>
            </div>
            <span class="description"> مثلا تصویر پروفایل اینستاگرام کاری شما </span>
        </label>
        <label>
            شماره تماس (اختیاری)
            <input type="tel" placeholder="091..." dir="ltr" name="phone"  value="<?php echo $step1['phone'];  ?>">
            <span class="description">از این شماره برای ارتباط با شما استفاده خواهد شد. حتی می‌تواند شماره ثابت باشد و یا خالی باشد</span>
        </label>
        <label>
            ایمیل شما (اختیاری)
            <input type="email" dir="ltr" name="email"  value="<?php echo $step1['email'];  ?>">
            <span class="description">
                از این ایمیل برای ارتباط با شما استفاده خواهد شد. میتواند خالی باشد
            </span>
        </label>
        <input type="submit" value="ذخیره و ادامه">
    </form>
</section>

<?php
wp_footer(); ?>
</body>
</html>