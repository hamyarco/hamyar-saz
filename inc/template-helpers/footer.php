<?php   defined('ABSPATH') || exit ("no access"); ?>
</div>
<?php

$default_args = [
    'script' =>'',
    'direct_scripts' => [],
    'vendor'=>[],
    ];
extract(hsaz_default_args($default_args,$arg));

?>

<!-- END: Page Main-->

<!-- BEGIN: Footer-->

<!--<footer class="page-footer footer footer-static footer-dark gradient-45deg-indigo-purple gradient-shadow navbar-border navbar-shadow">-->
<!--    <div class="footer-copyright">-->
<!--        <div class="container"><span>&copy; 2020 <a href="http://themeforest.net/user/pixinvent/portfolio?ref=pixinvent" target="_blank">PIXINVENT</a> All rights reserved.</span><span class="right hide-on-small-only">Design and Developed by <a href="https://pixinvent.com/">PIXINVENT</a></span></div>-->
<!--    </div>-->
<!--</footer>-->

<!-- END: Footer-->
<!-- BEGIN VENDOR JS-->

<script src="<?php echo HAMYAR_SAZ_MATERIALIZE_URL ?>app-assets/js/vendors.min.js"></script>
<?php
foreach ($vendor as $item){
    printf('<script src="%s/app-assets/%s"></script>',HAMYAR_SAZ_MATERIALIZE_URL, $item);
}
foreach ($direct_scripts as $script){
    printf('<script src="%s"></script>',$script);
}
?>
<!-- BEGIN VENDOR JS-->
<!-- BEGIN PAGE VENDOR JS-->
<!-- END PAGE VENDOR JS-->
<!-- BEGIN THEME  JS-->
<script src="<?php echo HAMYAR_SAZ_MATERIALIZE_URL ?>app-assets/vendors/select2/select2.full.min.js"></script>
<script src="<?php echo HAMYAR_SAZ_MATERIALIZE_URL ?>app-assets/vendors/quill/quill.min.js"></script>
<script src="<?php echo HAMYAR_SAZ_MATERIALIZE_URL ?>app-assets/js/plugins.js"></script>
<script src="<?php echo HAMYAR_SAZ_MATERIALIZE_URL ?>app-assets/js/search.js"></script>
<script src="<?php echo HAMYAR_SAZ_MATERIALIZE_URL ?>app-assets/js/custom/custom-script.js"></script>
<!-- END THEME  JS-->
<!-- BEGIN PAGE LEVEL JS-->
<!-- END PAGE LEVEL JS-->
<?php   hsaz_footer(); ?>
<?php echo $script; ?>
</body>

</html>