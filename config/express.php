<?php
/**
 * @author caojiayuan
 */

return [
    'default' => env('EXPRESS_DRIVER', 'ali'),

    'kdniao' => [
        'ebussionsid' => env('KDNIAO_EBUSSIONSID', ''),
        'appKey'      => env('KDNIAO_APPKEY', ''),
    ],

    'ali' => [
        // Default uri
        // https://market.aliyun.com/products/56928004/cmapi021863.html?spm=5176.2020520132.101.2.7cd37218n1PP72#sku=yuncode1586300000
        'baseUri' => env('ALI_APP_BASE_URI', 'https://wuliu.market.alicloudapi.com/kdi'),
        'appCode' => env('ALI_APP_CODE'),
    ]
];