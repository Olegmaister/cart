<?php

return [
    '/stock/create' => 'stock/create',
    '/discount' => 'pages/discount',
    '' => 'site/index',
    '/aktsii' => 'stocks',
    '/aktsii/one' => 'stocks/one',
    '/novosti' => 'blogs',
    ['class' => 'frontend\components\RedirectManager'],
    ['class' => 'frontend\components\SlugUrlManager'],
    'categories/products/<id:\d+>' => 'categories/products',




    //customer
    '/customer/network/<_a>' => 'customer/network/<_a>',
    '/account/simpleregister' => 'customer/signup/simpleregister',
    '/account/account' => 'customer/account',
    '<_a:logout>' => 'customer/login/<_a>',
    '/account/<_a:order|wishlist|accumulative|only-for-you|bulk-orders|reviews|reserve|new-password|upload-avatar>' => 'customer/account/<_a>',
    '/tempory/<_a:delivery|payment|opt|faq|about>' => 'temporary/<_a>',
    '/account/<_a:[\w]+>' => '/cabinet/account/<_a>',
    //stores
    '/our-stores' => 'stores',

    // список избранного
    '/wishlist/<action:(add|check)>/<productId:\d+>' => 'customer/wishlist/<action>',
    '/wishlist/<action:(delete-all|delete|get-list|count)>' => 'customer/wishlist/<action>',

    // список сравнение товаров
    //'/compare/<action:(add|check)>/<productId:\d+>' => 'customer/compare/<action>',
    //'/compare/<action:(delete-all|delete|get-list|count|get-products|test)>' => 'customer/compare/<action>',
    '/comparison/<category:[\w-]+>' => 'customer/compare/view',
    '/compare/<action>' => 'customer/compare/<action>',


    // поиск
    '/search-ajax' => 'search/search-ajax',
    '/search-more/get-more-product' => 'search/get-more-product',
    '/search<text>' => 'search/index',

    '/create-product-reserve' => 'reserve/create-reserve',
    '/checkout/check-product-in-store' => 'checkout/check-product-in-store',

    // payment callback
    '/response-liqpay' => 'payment/response-liqpay',
    '/response-wayforpay' => 'payment/response-wayforpay',
    '/response-privat' => 'payment/response-privat',

    '/synchronize/sync-price' => 'synchronize/sync-price',
    '/synchronize/sync-product' => 'synchronize/sync-product',
    '/synchronize/sync-customer' => 'synchronize/sync-customers',
    '/synchronize/sync-order' => 'synchronize/sync-order',
    '/synchronize/sync-order-status' => 'synchronize/sync-order-status',

    // Sitemap
    '/sitemap.xml' => 'sitemap/index',
    '/sitemap_ru.xml' => 'sitemap/index-lang',
    '/sitemap_uk.xml' => 'sitemap/index-lang',
    '/sitemap_en.xml' => 'sitemap/index-lang',
    '/sitemap-image.xml' => 'sitemap/map-images',

    '/add-subscribe' => 'subscribe/add-subscribe',
    '/price-watch/<action:(add|delete)>' => 'price-watch/<action>',

    '/update-language' => 'language/update-language',
    '/download-invoice' => 'invoice/download-invoice',
];
