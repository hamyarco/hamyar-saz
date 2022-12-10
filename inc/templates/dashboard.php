<?php   defined('ABSPATH') || exit ("no access");
$site_list=\HamyarSaz\core\package::get_instance()->getPackages();
if (empty($site_list)){
    header("Location: ".home_url('/hamsaz/setup/'));
//    \HamyarSaz\core\endPoint::loadTemplate('start');
    return;
}
?>
<?php \HamyarSaz\core\helpers::template( 'header',['title'=>'داشبورد']); ?>

<div class="row">
    <?php foreach ($site_list as $site): ?>
    <div class="col s12 m4 l3">
        <div class="card">
            <div class="card-image">
                <img src="<?php echo HAMYAR_SAZ_ASSETS_URL ?>img/empty-website.jpg" alt="sample">
            </div>
            <div class="card-content">
                <p class="black-text">
                    <?php echo $site->title ?>
                </p>
            </div>
            <div class="card-action">
                <a href="<?php echo hamyar_saz_get_admin_url('website/'.$site->id.'/dashboard') ?>" class="waves-effect waves-light btn gradient-45deg-red-pink float-right">ورود</a>
            </div>
        </div>
    </div>
<?php endforeach; ?>
</div>

<?php \HamyarSaz\core\helpers::template( 'footer'); ?>