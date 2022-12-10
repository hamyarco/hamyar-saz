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
        $website=get_query_var('website');
        if (is_numeric($website))
        return [
            [
                'title' => 'داشبورد',
                'icon' => 'dashboard',
                'url' => "hamsaz/website/{$website}/dashboard/",
                'childs' => []
            ],
            [
                'title' => 'محصولات',
                'icon' => 'add_shopping_cart',
                'url' => "hamsaz/website/{$website}/products/",
                'childs' => [
                    ['title' => 'لیست محصولات', 'url' => ["hamsaz/website/{$website}/products/","hamsaz/website/{$website}/products/add/","hamsaz/website/{$website}/products/edit/"]],
//                    ['title' => 'دسته محصولات', 'url' => 'hamsaz/products/categories/'],
//                    ['title' => 'افزودن محصول', 'url' => 'hamsaz/products/add/'],
                    ['title' => 'کوپن', 'url' => ["hamsaz/website/{$website}/products/coupons/","hamsaz/website/{$website}/products/coupons/add/"]],
                    ['title' => 'سفارش‌ها', 'url' => ["hamsaz/website/{$website}/products/orders/","hamsaz/website/{$website}/products/orders/edit/"]],
                ]
            ],
            [
                'title' => 'نوشته‌ها',
                'icon' => 'dvr',
                'url' => ["hamsaz/website/{$website}/posts/","hamsaz/website/{$website}/posts/add/","hamsaz/website/{$website}/posts/edit/"],
//                'childs' => [
//                    ['title' => 'لیست نوشته‌ها', 'url' => 'hamsaz/posts/'],
//                    ['title' => 'افزودن نوشته', 'url' => 'hamsaz/posts/add/'],
//                ]
            ],
            [
                'title' => 'برگه ها',
                'icon' => 'pages',
                'url' => ["hamsaz/website/{$website}/pages/","hamsaz/website/{$website}/pages/add/","hamsaz/website/{$website}/pages/edit/"],
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
                'url' => "hamsaz/website/{$website}/settings/",
                'childs' => [
                    ['title' => 'عمومی', 'url' => "hamsaz/website/{$website}/settings/general"],
                    ['title' => 'شیوه پرداخت', 'url' => "hamsaz/website/{$website}/settings/payment/"],
//                    ['title' => 'تنظیمات سامانه پیامک', 'url' => 'hamsaz/settings/sms/']
                ]
            ],
            [
                'title' => 'کلی',
                'icon' => 'pie_chart_outlined',
                'url' => "hamsaz/website/{$website}/other/",
                'childs' => [
                    ['title' => 'دیدگاه ها', 'url' => "hamsaz/website/{$website}/other/comments"],
                    ['title' => 'آمار', 'url' => "hamsaz/website/{$website}/other/stats/"],
//                    ['title' => 'نوتیفیکیشن', 'url' => 'hamsaz/other/notification/']
                ]
            ]
        ];
        else
            return [
                [
                    'title' => 'داشبورد',
                    'icon' => 'dashboard',
                    'url' => 'hamsaz/dashboard/',
                    'childs' => []
                ]
            ];
    }

}