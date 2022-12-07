<?php
/**
 * Created by PhpStorm.
 * User: alireza azami (hamyar.co)
 * Date: 01.11.22
 * Time: 17:13
 */


namespace HamyarSaz\core;


class navbar
{
    public static function menu()
    {
        return [
            [
                'title' => 'داشبورد',
                'icon' => 'dashboard',
                'url' => 'hamsaz/dashboard/',
                'childs' => []
            ],
            [
                'title' => 'محصولات',
                'icon' => 'add_shopping_cart',
                'url' => 'hamsaz/products/',
                'childs' => [
                    ['title' => 'لیست محصولات', 'url' => ['hamsaz/products/','hamsaz/products/add/','hamsaz/products/edit/']],
//                    ['title' => 'دسته محصولات', 'url' => 'hamsaz/products/categories/'],
//                    ['title' => 'افزودن محصول', 'url' => 'hamsaz/products/add/'],
                    ['title' => 'کوپن', 'url' => ['hamsaz/products/coupons/','hamsaz/products/coupons/add/']],
                    ['title' => 'سفارش‌ها', 'url' => ['hamsaz/products/orders/','hamsaz/products/orders/edit/']],
                ]
            ],
            [
                'title' => 'نوشته‌ها',
                'icon' => 'dvr',
                'url' => ['hamsaz/posts/','hamsaz/posts/add/','hamsaz/posts/edit/'],
//                'childs' => [
//                    ['title' => 'لیست نوشته‌ها', 'url' => 'hamsaz/posts/'],
//                    ['title' => 'افزودن نوشته', 'url' => 'hamsaz/posts/add/'],
//                ]
            ],
            [
                'title' => 'برگه ها',
                'icon' => 'pages',
                'url' => ['hamsaz/pages/','hamsaz/pages/add/','hamsaz/pages/edit/'],
//                'childs' => [
//                    ['title' => 'لیست برگه', 'url' => 'hamsaz/pages/'],
//                    ['title' => 'افزودن برگه', 'url' => 'hamsaz/pages/add/'],
//                ]
            ],
//            [
//                'title' => 'مارکتینگ',
//                'icon' => 'assistant_photo',
//                'url' => 'hamsaz/marketing/',
//                'childs' => [
//                    ['title' => 'فرم‌های مهم', 'url' => 'hamsaz/marketing/forms'],
//                    ['title' => 'پاپ آپ', 'url' => 'hamsaz/marketing/popup/'],
//                    ['title' => 'استیکی بار', 'url' => 'hamsaz/marketing/stiky/'],
//                    ['title' => 'پیامک گروهی', 'url' => 'hamsaz/marketing/sms/'],
//                    ['title' => 'نوتیف گروهی', 'url' => 'hamsaz/marketing/notification/'],
//                ]
//            ],
            [
                'title' => 'تنظیمات',
                'icon' => 'settings_brightness',
                'url' => 'hamsaz/settings/',
                'childs' => [
                    ['title' => 'عمومی', 'url' => 'hamsaz/settings/general'],
                    ['title' => 'شیوه پرداخت', 'url' => 'hamsaz/settings/payment/'],
//                    ['title' => 'تنظیمات سامانه پیامک', 'url' => 'hamsaz/settings/sms/']
                ]
            ],
            [
                'title' => 'کلی',
                'icon' => 'pie_chart_outlined',
                'url' => 'hamsaz/other/',
                'childs' => [
                    ['title' => 'دیدگاه ها', 'url' => 'hamsaz/other/comments'],
                    ['title' => 'آمار', 'url' => 'hamsaz/other/stats/'],
//                    ['title' => 'نوتیفیکیشن', 'url' => 'hamsaz/other/notification/']
                ]
            ]
        ];
    }

}