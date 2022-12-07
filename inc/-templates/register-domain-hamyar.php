<?php defined('ABSPATH') || exit ("no access"); ?>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>درخواست ثبت دامنه</title>
    <?php
    wp_head(); ?>
</head>
<body <?php body_class(['flex-center']); ?>>
<?php
$data=\HamyarSaz\core\helpers::getWizardMeta('register-domain-hamyar',[ 'name', 'family', 'stat', 'city', 'address', 'national_code', 'postal_code', 'phone', 'mobile', 'email','finished']);

?>

<section id="hsw">
    <form  enctype="multipart/form-data" action="" method="post" >
        <span class="circle-loader"></span>
        <?php wp_nonce_field() ?>
        <input type="hidden" name="action" value="register-domain-hamyar">
        <h1>اطلاعات مورد نیاز</h1>
        <?php if ($data['finished']!==1): ?>
            <div class="alert-text">
                <p class="important">
                    به منظور ثبت نام شما در سایت ایرنیک و همچنین تهیه هاست و دامنه ، لازم است اطلاعات هویتی را وارد نمایید.
                    <br>
                    <span class="red bold mt-10 inline-block">توجه کنید که این اطلاعات باید صحیح باشد و در صورتی که اطلاعات وارد شده صحیح نباشد ، امکان ثبت نام وجود نخواهد داشت.</span>
                </p>
                <div class="select-step" >
                        <div class="prev-step" onclick="toggle_fiels('.alert-result','.alert-text')">متوجه شدم</div>
                </div>
            </div>
            <div class="alert-result" style=" display: none">
                <label> نام*
                    <input type="text" placeholder="نام" name="name" required value="<?php echo $data['name'];  ?>">
                </label>
                <label>
                    نام خانوادگی*
                    <input type="text" placeholder="فامیلی" name="family" required  value="<?php echo $data['family'];  ?>">
                </label>
                <label>
                    کد ملی*
                    <input type="tel" dir="ltr" name="national-code" required  value="<?php echo $data['national_code'];  ?>">
                </label>
                <label>
                    استان*
                    <input type="text" name="stat" required  value="<?php echo $data['stat'];  ?>" placeholder="استان محل سکونت">
                </label>
                <label>
                    شهر*
                    <input type="text" name="city" required  value="<?php echo $data['city'];  ?>" placeholder="شهر محل سکونت">
                </label>
                <label>
                    آدرس*
                    <textarea name="address" rows="4" placeholder="آدرس محل سکونت"><?php echo $data['address'];  ?></textarea>
                </label>

                <label>
                    کد پستی*
                    <input type="tel" dir="ltr" name="postal-code" required  value="<?php echo $data['postal_code'];  ?>">
                </label>
                <label>
                    تلفن ثابت به همراه کد شهر*
                    <input type="tel" dir="ltr" name="phone" required placeholder="021..."  value="<?php echo $data['phone'];  ?>">
                </label>
                <label>
                    تلفن همراه*
                    <input type="tel" dir="ltr" name="mobile" required placeholder="09..."  value="<?php echo $data['mobile'];  ?>">
                </label>
                <label>
                    پست الکترونیک (email)*
                    <input type="email" dir="ltr" name="email" required placeholder="ali@gmail.com"  value="<?php echo $data['email'];  ?>">
                    <span class="description" onclick="hs_show_video('create-email-video')">در صورتی که ایمیل ندارید میتوانید از طریق راهنما ایمیل بسازید
            <span class="link"> (مشاهده راهنما) </span>
            </span>
                </label>
                <div class="select-step" >
                    <input class="next-step" type="submit" value="ثبت درخواست">
                    <div class="prev-step" onclick="hs_next_step('select-domain')">مرحله قبل</div>
                </div>
            </div>
        <?php else: ?>
            <p class="important">
                همکاران ما در حال راه اندازی وبسایت شما می‌باشند
            </p>
        <?php endif; ?>
    </form>
</section>
<?php wp_footer(); ?>
</body>
</html>