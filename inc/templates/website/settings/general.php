<?php
defined( 'ABSPATH' ) || exit ( "no access" ); ?>
<?php
\HamyarSaz\core\helpers::template( 'header', ['title' => 'تنظیمات عمومی'] );
$bacs_settings=get_option( 'woocommerce_bacs_settings', ['enabled'=>'no','title'=>'انتقال مستقیم بانکی','description'=>'پرداخت خود را مستقیما به حساب بانکی ما واریز کنید.خواهشمندیم شماره سفارش خود  استفاده کنید.سفارش شما تا زمانی که وجوه به حساب ما وارد نشود ارسال نخواهد شد.'] );
$bacs=get_option(
    'woocommerce_bacs_accounts',
    array(
        array(
            'account_name'   => '',
            'account_number' => '',
            'sort_code'      => '',
            'bank_name'      => '',
            'iban'           => '',
            'bic'            => '',
        ),
    )
);

?>
    <div class="row users-list-wrapper" id="ecommerce-products">

        <div class="col s12 settings">
            <ul class="collapsible collapsible-accordion">
                <li>
                    <div class="collapsible-header" tabindex="0">
                        <i class="material-icons">payment</i>
                        تنظیمات فروشگاه (ناقص)
                        <i class="material-icons">arrow_drop_down</i>
                    </div>
                    <div class="collapsible-body">
                        <form action="" method="post" class="items row">
                            <?php wp_nonce_field() ?>
                            <div class="switch mb-1">
                                <span class="mr-2"> دریافت آدرس حمل و نقل: </span>
                                <label>
                                    غیر فعال
                                    <input type="checkbox" name="payment[bacs][enabled]" value="yes" <?php
                                    checked( $bacs_settings[ 'enabled' ], 'yes' ) ?>>
                                    <span class="lever"></span>
                                    فعال
                                </label>
                            </div>
                            <div class="switch mb-1">
                                <span class="mr-2"> دریافت  </span>
                                <label>
                                    غیر فعال
                                    <input type="checkbox" name="payment[bacs][enabled]" value="yes" <?php
                                    checked( $bacs_settings[ 'enabled' ], 'yes' ) ?>>
                                    <span class="lever"></span>
                                    فعال
                                </label>
                            </div>
                            <div class="input-field col s12">
                                <input id="payment[bacs][title]" type="text" name="payment[bacs][title]"
                                       value="<?php echo $bacs_settings[ 'title' ] ?>">
                                <label for="payment[bacs][title]" class="">عنوان</label>
                            </div>
                            <div class="input-field col s12">
                                <textarea  id="payment[bacs][description]" class="materialize-textarea" name="payment[bacs][description]" cols="30" rows="10"><?php echo $bacs_settings[ 'description' ] ?></textarea>
                                <label for="payment[bacs][description]" class="">توضیحات</label>
                            </div>
                            <div class="input-field col s12">
                                <input id="payment[bacs][bank_name]" type="text" name="payment[bacs][bank_name]"
                                       value="<?php echo $bacs[0][ 'bank_name' ] ?>">
                                <label for="payment[bacs][bank_name]" class="">نام بانک</label>
                            </div>
                            <div class="input-field col s12">
                                <input id="payment[bacs][account_name]" type="text" name="payment[bacs][account_name]"
                                       value="<?php echo $bacs[0][ 'account_name' ] ?>">
                                <label for="payment[bacs][account_name]" class="">نام حساب</label>
                            </div>
                            <div class="input-field col s12">
                                <input id="payment[bacs][account_number]" type="text" name="payment[bacs][account_number]"
                                       value="<?php echo $bacs[0][ 'account_number' ] ?>">
                                <label for="payment[bacs][account_number]" class="">شماره کارت <label>
                            </div>
                            <div class="input-field col s12">
                                <input id="payment[bacs][sort_code]" type="text" name="payment[bacs][sort_code]"
                                       value="<?php echo $bacs[0][ 'sort_code' ] ?>">
                                <label for="payment[bacs][sort_code]" class="">شماره حساب <label>
                            </div>
                            <div class="input-field col s12">
                                <input id="payment[bacs][iban]" type="text" name="payment[bacs][iban]"
                                       value="<?php echo $bacs[0][ 'iban' ] ?>">
                                <label for="payment[bacs][iban]" class="">شماره شبا <label>
                            </div>
                            <input type="submit" class="mr-2 mb-2 btn waves-effect waves-light green darken-1 right white-text pl-5 pr-5" value="ذخیره">
                        </form>
                    </div>
                </li>
            </ul>

        </div>
    </div>

<?php
\HamyarSaz\core\helpers::template( 'footer', [] ); ?>