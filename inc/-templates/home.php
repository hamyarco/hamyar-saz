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
    <section class="products-archive">
        <section class="product-single" >
            <a href="" target="_blank">
                <img src="" alt="">
                <h2></h2>
                <div class="price">
                    <span class="price--full"></span>
                    <span class="price--sales"></span>
                </div>
            </a>
            <span class="edit"> ویرایش این محصول </span>
        </section>
    </section>
</main>
<footer>

</footer>
<?php
wp_footer(); ?>
</body>
</html>