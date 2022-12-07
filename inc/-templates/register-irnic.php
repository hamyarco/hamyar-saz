<?php defined('ABSPATH') || exit ("no access"); ?>
<html lang="fa" dir="rtl" data-hidden="admin-bar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ثبت نام ایرنیک</title>
    <?php
    wp_head(); ?>
</head>
<body <?php body_class(['flex-center']); ?>>
<?php
$data=\HamyarSaz\core\helpers::getWizardMeta('register-irnic',['irnic']);

?>
<section id="hsw">
    <form  enctype="multipart/form-data" action="" method="post" >
        <span class="circle-loader"></span>

        <?php wp_nonce_field() ?>
        <input type="hidden" name="action" value="irnic-register">
        <h1>ثبت نام در ایرنیک
            <span class="description">
                برای خرید دامنه ir باید یک حساب کاربری در ایرنیک ایجاد نمایید.
            </span>
        </h1>
        <div class="manual-video">
            <video controls src="https://ir-west-1.s3.poshtiban.com/hamyarbc-hamyarwp.s3.ir-west-1.poshtiban.com/public/irnic.mp4"></video>
        </div>

        <label>
            شناسه ایرنیک *
            <input type="text" dir="ltr" placeholder="شناسه ایرنیک خود را وارد کنید " name="irnic" required  value="<?php echo $data['irnic'];  ?>">
        </label>
        <div class="select-step" >
            <input class="next-step" type="submit" value="مرحله بعد">
            <div class="prev-step" onclick="hs_next_step('select-domain')">مرحله قبل</div>
        </div>
    </form>
</section>
<!-- /#domain-help-video -->
<?php
wp_footer(); ?>
</body>
</html>