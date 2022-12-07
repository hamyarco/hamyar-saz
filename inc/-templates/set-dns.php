<?php defined('ABSPATH') || exit ("no access"); ?>
<?php
$select_domain=\HamyarSaz\core\helpers::getWizardMeta('select-domain',['domain-selector','domain-name','domain-register']);
if (empty($select_domain) || empty($select_domain['domain-name'])){wp_redirect( add_query_arg( ['step' => 'select-domain']) );}
$domain=$select_domain['domain-name'];

?>
<html lang="fa" dir="rtl" data-hidden="admin-bar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ثبت اطلاعات dns</title>
    <?php
    wp_head(); ?>
</head>
<body <?php body_class(['flex-center']); ?>>

<section id="hsw" class="set-dns select-domain">
    <form  enctype="multipart/form-data" action="" method="post" >
        <span class="circle-loader"></span>
        <?php wp_nonce_field() ?>
        <input type="hidden" name="action" value="set-dns">
        <h1>تنظیم NameServer
        </h1>

        <div class="set-domain-ns">
            <input type="radio" name="set-ns" id="set-ns-myself" value="myself">
            <label for="set-ns-myself" onclick="toggle_fiels('.set-ns-myself','.set-ns-hamyar')">
                <span class="flex-row vertical-center">
                <span class="tick"></span>
                خودم تنظیم می‌کنم
                </span>
            </label>
            <input type="radio" name="set-ns" id="set-ns-hamyar" value="hamyar">
            <label for="set-ns-hamyar" onclick="toggle_fiels('.set-ns-hamyar','.set-ns-myself')">
                <span class="flex-row vertical-center">
                <span class="tick"></span>
                نیاز به کمک دارم
                </span>
            </label>
        </div>

        <div class="set-ns-myself" style="display: none">
            <p>
                لطفا وارد پنل مدیریت دامنه خود شوید. <br> سپس به بخش NameServer مراجعه کرده و مقادیر ns1, ns2 را به این مقادیر تنظیم نمایید
            </p>
            <ul class="left-direction-align">
                <li>
                    <strong>ns1:</strong>
                    <span onclick="copyToClipboard('ns1.hamyarsupport.com')">ns1.hamyarsupport.com</span>
                </li>
                <li> <strong>ns2:</strong>
                    <span onclick="copyToClipboard('ns2.hamyarsupport.com')">ns2.hamyarsupport.com</span>
                </li>
            </ul>
        </div>

        <div class="set-ns-hamyar" style="display: none">
            <h2>ثبت دامنه</h2>
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
            document.querySelector('#<?php echo $select_domain['domain-selector'] ?>').nextElementSibling.click();
            document.querySelector('[name="domain-selector"]').value='<?php echo $select_domain['domain-name'] ?>';
            document.querySelector('[name="domain-register"][value="<?php echo $select_domain['domain-register'] ?>"]').nextElementSibling.click();
        })
        <?php
        }
        ?>
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