<span class="hide-on-small-onl">تنظیمات</span><i class="material-icons right">arrow_drop_down</i></a>

<?php
$website = get_query_var( 'website' );
if (is_numeric($website)){ global $website_object; ?>
    <ul class="dropdown-content" id="dropdown1" tabindex="0">
        <li tabindex="0"><a class="grey-text text-darken-2" href="<?php echo $website_object->domain??'#' ?>" target="_blank">مشاهده وبسایت</a></li>
        <li tabindex="0"><a class="grey-text text-darken-2" href="https://hamyar.co/" target="_blank">همیار آکادمی</a></li>
        <li class="divider" tabindex="-1"></li>
        <li tabindex="0"><a class="grey-text text-darken-2" href="<?php echo get_home_url('/hamsaz/dashboard/') ?>">خروج</a></li>
    </ul>
<?php }else{ ?>
    <ul class="dropdown-content" id="dropdown1" tabindex="0">
        <li tabindex="0"><a class="grey-text text-darken-2" href="<?php echo get_site_url() ?>" target="_blank">مشاهده وبسایت</a></li>
        <li tabindex="0"><a class="grey-text text-darken-2" href="<?php echo admin_url(); ?>" target="_blank">ادمین وردپرس</a></li>
        <li tabindex="0"><a class="grey-text text-darken-2" href="https://hamyar.co/" target="_blank">همیار آکادمی</a></li>
        <li class="divider" tabindex="-1"></li>
        <li tabindex="0"><a class="grey-text text-darken-2" href="<?php echo wp_logout_url() ?>">خروج</a></li>
    </ul>
<?php } ?>
