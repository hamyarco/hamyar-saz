<?php   defined('ABSPATH') || exit ("no access"); ?>
<?php
$default_args = [
    'title' => 'آرشیو محصولات',
    'body_class' => '',
    'body_id' => '',
    'direct_styles' => [],
];
extract(hsaz_default_args($default_args,$arg));

?>
<!DOCTYPE html>
<html class="loading" lang="fa" data-textdirection="rtl">
<!-- BEGIN: Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="Materialize is a Material Design Admin Template,It's modern, responsive and based on Material Design by Google.">
    <meta name="keywords" content="materialize, admin template, dashboard template, flat admin template, responsive admin template, eCommerce dashboard, analytic dashboard">
    <meta name="author" content="ThemeSelect">
    <title><?php
        hsaz_e( $title, 'همیار ساز' ) ?></title>
    <link rel="apple-touch-icon" href="<?php echo HAMYAR_SAZ_MATERIALIZE_URL ?>app-assets/images/favicon/apple-touch-icon-152x152.png">
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo HAMYAR_SAZ_MATERIALIZE_URL ?>app-assets/images/favicon/favicon-32x32.png">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!-- BEGIN: VENDOR CSS-->
    <link rel="stylesheet" type="text/css" href="<?php echo HAMYAR_SAZ_MATERIALIZE_URL ?>app-assets/vendors/vendors-rtl.min.css">
    <!-- END: VENDOR CSS-->
    <link rel="stylesheet" type="text/css" href="<?php echo HAMYAR_SAZ_MATERIALIZE_URL ?>app-assets/css-rtl/style-rtl.css">
    <!-- BEGIN: Page Level CSS-->
    <link rel="stylesheet" type="text/css" href="<?php echo HAMYAR_SAZ_MATERIALIZE_URL ?>app-assets/css-rtl/themes/vertical-modern-menu-template/materialize.css">
    <link rel="stylesheet" type="text/css" href="<?php echo HAMYAR_SAZ_MATERIALIZE_URL ?>app-assets/css-rtl/themes/vertical-modern-menu-template/style.css">
    <link rel="stylesheet" type="text/css" href="<?php echo HAMYAR_SAZ_MATERIALIZE_URL ?>app-assets/vendors/quill/quill.snow.css">
    <!-- END: Page Level CSS-->
    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="<?php echo HAMYAR_SAZ_MATERIALIZE_URL ?>app-assets/css-rtl/custom/custom.css">
    <!-- END: Custom CSS-->
    <?php
    foreach ($direct_styles as $style){
        printf('<link rel="stylesheet" type="text/css" href="%s"> ',$style);
    }
    ?>
    <?php hsaz_head(); ?>
</head>
<!-- END: Head-->

<body class="vertical-layout vertical-menu-collapsible page-header-dark vertical-modern-menu preload-transitions 2-columns <?php echo implode(' ',get_body_class(['hamyar-saz', $body_class])); ?>" data-open="click" data-menu="vertical-modern-menu" data-col="2-columns"
    <?php echo (!empty($body_id))?'id="'.$body_id.'"':'' ?>
>

<!-- BEGIN: Header-->
<header class="page-topbar hide-on-large-only" id="header">
    <?php
    $location=$_SERVER['REQUEST_URI'];
    if (strpos($location,'?')!==false){
        $location=substr($_SERVER['REQUEST_URI'],0, strpos($_SERVER['REQUEST_URI'],'?'));
    }
    if ($location==='/hamsaz/dashboard/' || $location==='/hamsaz/'): ?>
        <div class="row navbar navbar-fixed">
            <nav class="navbar-main navbar-color nav-collapsible sideNav-lock navbar-dark gradient-45deg-indigo-purple no-shadow">
                <div class="nav-wrapper">
                    <a class="btn dropdown-settings waves-effect waves-light breadcrumbs-btn right show-on-medium-and-down" href="#!" data-target="dropdown1"><i class="material-icons show-on-medium-and-down">settings</i>
                        <?php \HamyarSaz\core\helpers::template( 'setting-navbar'); ?>
                    </a>
                </div>
            </nav>
        </div>
    <?php else: ?>
        <div class="row navbar navbar-fixed gradient-45deg-indigo-purple">
            <div class="nav-wrapper">
                <a class="btn waves-effect waves-light breadcrumbs-btn right show-on-medium-and-down mr-2 back-dashboard" href="<?php echo hamyar_saz_get_admin_url('/dashboard') ?>"><i class="material-icons show-on-medium-and-down">keyboard_backspace</i>
                </a>
            </div>
        </div>
    <?php endif; ?>
</header>

<!-- BEGIN: SideNav-->
<aside class="sidenav-main nav-expanded nav-lock nav-collapsible sidenav-light sidenav-active-square">
    <div class="brand-sidebar">
        <h1 class="logo-wrapper"><a class="brand-logo darken-1" href="<?php echo home_url(); ?>"><img class="hide-on-med-and-down" src="<?php echo HAMYAR_SAZ_MATERIALIZE_URL ?>app-assets/images/logo/materialize-logo-color.png" alt="materialize logo" /><img class="show-on-medium-and-down hide-on-med-and-up" src="<?php echo HAMYAR_SAZ_MATERIALIZE_URL ?>app-assets/images/logo/materialize-logo.png" alt="materialize logo" /><span class="logo-text hide-on-med-and-down">همیارساز</span></a><a class="navbar-toggler" href="#"><i class="material-icons">radio_button_checked</i></a></h1>
    </div>
    <ul class="sidenav sidenav-collapsible leftside-navigation collapsible sidenav-fixed menu-shadow" id="slide-out" data-menu="menu-navigation" data-collapsible="menu-accordion">
        <?php foreach (\HamyarSaz\core\navbar::menu() as $parent):?>
            <li class="bold <?php hsaz_active_menu($parent['url'],'active open') ?>">
                <a class="<?php echo (!empty($parent['childs']))?'collapsible-header':
                    hsaz_active_menu($parent['url'],'active',false) ?> waves-effect waves-cyan "
                   href="<?php echo (isset($parent['url']) && empty($parent['childs']))? '/'.(is_array($parent['url'])?$parent['url'][0]:$parent['url']):'JavaScript:void(0)' ?>"><i class="material-icons"><?php echo $parent['icon'] ?></i><span class="menu-title"><span ><?php echo $parent['title'] ?></span></span></a>
                <div class="collapsible-body">
                    <ul class="collapsible collapsible-sub" data-collapsible="accordion">
                        <?php if(isset($parent['childs'])) foreach ($parent['childs'] as $child): ?>
                            <li>
                                <a  class="<?php hsaz_active_menu($child['url'],'active',false) ?>" href="/<?php echo is_array($child['url'])?$child['url'][0]:$child['url'] ?>"><i class="material-icons">radio_button_unchecked</i><span data-i18n="Products Page"><?php echo $child['title'] ?></span></a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </li>
        <?php endforeach; ?>
    </ul>
    <div class="navigation-background"></div><a class="sidenav-trigger btn-sidenav-toggle btn-floating btn-medium waves-effect waves-light hide-on-large-only" href="#" data-target="slide-out"><i class="material-icons">menu</i></a>
</aside>
<!-- END: SideNav-->

<!-- BEGIN: Page Main-->
<div id="main">
    <div class="row">
        <div class="gradient-45deg-indigo-purple breadcrumbs-dark pb-0 pt-3 pb-3" id="breadcrumbs-wrapper">
            <!-- Search for small screen-->
            <div class="container">
                <div class="row">
                    <div class="col s10 m6 l6">
                        <h5 class="breadcrumbs-title mt-0 mb-0"><span><?php
                                hsaz_e( $title) ?></span></h5>
                    </div>
                    <div class="col s2 m6 l6">
                        <?php if ($location==='/hamsaz/dashboard/' || $location==='/hamsaz/'): ?>
                            <a class="btn dropdown-settings waves-effect waves-light breadcrumbs-btn right hide-on-med-and-down" href="#!" data-target="dropdown1"><i class="material-icons hide-on-med-and-up">settings</i>
                                <?php \HamyarSaz\core\helpers::template( 'setting-navbar'); ?></a>
                        <?php else: ?>
                            <a class="btn waves-effect waves-light breadcrumbs-btn right hide-on-med-and-down mr-2 back-dashboard" href="<?php echo hamyar_saz_get_admin_url('/dashboard') ?>"><i class="material-icons ">keyboard_backspace</i>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>