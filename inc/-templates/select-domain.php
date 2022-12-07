<?php defined('ABSPATH') || exit ("no access"); ?>
<html lang="fa" dir="rtl" data-hidden="admin-bar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>انتخاب دامنه</title>
    <?php
    wp_head(); ?>
</head>
<body <?php body_class(['flex-center']); ?>>

<section id="hsw" class="select-domain">
    <form  enctype="multipart/form-data" action="" method="post" >
        <span class="circle-loader"></span>

        <?php wp_nonce_field() ?>
        <input type="hidden" name="action" value="select-domain">
        <h1>انتخاب دامنه
            <span class="description" onclick="hs_show_video('domain-help-video')"> دامنه چیست؟
            <span class="link"> (مشاهده راهنما) </span>
            </span>
        </h1>
        <input type="hidden" name="domain-selector" id="do-not-have-domain" value="do-not-have-domain">
        <div class="do-not-have-domain" >
            <div class="register-domain-selector">
                <input type="radio" name="domain-register" id="domain-register-myself" value="myself">
                <label for="domain-register-myself">
                    <span class="flex-row vertical-center">
                     <span class="tick"></span>
                    می‌خواهم خودم دامنه را ثبت کنم
                    </span>
                    <span class="description"> در این صورت شما با دیدن ویدیوی راهنمای ثبت نام در ایرنیک و ایرانسرور دامنه خود را انتخاب میکنید </span>
                    <!-- /.description -->
                </label>
                <input type="radio" name="domain-register" id="domain-register-hamyar" value="hamyar">
                <label for="domain-register-hamyar">
                    <span class="flex-row vertical-center">
                    <span class="tick"></span>
                    به کمک تیم همیار برای ثبت دامنه نیاز دارم
                    </span>
                    <span class="description"> در این صورت شما باید اطلاعات مورد نیاز برای ثبت دامنه را ثبت نمایید تا همکاران ما این کار را برای شما انجام دهند </span>

                </label>
            </div>
        </div>
        <div class="select-step" >
            <input class="next-step" type="submit" value="مرحله بعد">
            <div class="prev-step" onclick="hs_next_step('product-ready')">مرحله قبل</div>
        </div>
    </form>
    <script>
        <?php
        $select_domain=\HamyarSaz\core\helpers::getWizardMeta('select-domain',['domain-selector','domain-name','domain-register']);
        if (!empty($select_domain)){
        ?>
        document.addEventListener("DOMContentLoaded", function(event) {
            document.querySelector('[name="domain-register"][value="<?php echo $select_domain['domain-register'] ?>"]').nextElementSibling.click();
        })


        <?php } ?>
    </script>
</section>
<div class="hs-video-popup" id="domain-help-video" style="display: none;">
    <div class="video-wrapper">
        <span class="close" onclick="close_video_popup(this)">&#x2715;</span>
        <video controls src="https://ir-west-1.s3.poshtiban.com/hamyarbc-hamyarwp.s3.ir-west-1.poshtiban.com/public/business-crisis.mp4"></video>
    </div>
</div>
<!-- /#domain-help-video -->
<?php
wp_footer(); ?>
</body>
</html>