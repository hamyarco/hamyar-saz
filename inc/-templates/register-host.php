<?php defined('ABSPATH') || exit ("no access"); ?>
<html lang="fa" dir="rtl" data-hidden="admin-bar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>خرید هاست</title>
    <?php
    wp_head(); ?>
</head>
<body <?php body_class(['flex-center']); ?>>
<?php
$data=\HamyarSaz\core\helpers::getWizardMeta('register-host',['username','password','server']);

?>
<section id="hsw">
    <form  enctype="multipart/form-data" action="" method="post" >
        <span class="circle-loader"></span>

        <?php wp_nonce_field() ?>
        <input type="hidden" name="action" value="register-host">
        <h1>خرید هاست
            <span class="description">
                جهت خرید هاست باید با اکانت ایرانسرور وارد شوید و مراحل خرید را مانند آموزش انجام دهید.
            </span>
        </h1>
        <div class="manual-video">
            <video controls src="https://ir-west-1.s3.poshtiban.com/hamyarbc-hamyarwp.s3.ir-west-1.poshtiban.com/public/host.mp4"></video>
        </div>

        <label>
            نام کاربری*
            <input type="text" dir="ltr" placeholder="نام کاربری اکانت ایران سرور " name="username" required  value="<?php echo $data['username'];  ?>">
        </label>
        <label>
            رمز عبور*
            <input type="text" dir="ltr" placeholder="رمز عبور اکانت ایران سرور" name="password" required  value="<?php echo $data['password'];  ?>">
        </label>
        <div class="select-step" >
            <input class="next-step" type="submit" value="مرحله بعد">
            <div class="prev-step" onclick="hs_next_step('register-domain')">مرحله قبل</div>
        </div>
    </form>
</section>
<!-- /#domain-help-video -->
<?php
wp_footer(); ?>
</body>
</html>