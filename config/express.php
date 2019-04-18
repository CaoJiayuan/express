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
        'baseUri' => env('ALI_APP_BASE_URI', 'https://wuliu.market.alicloudapi.com/kdi'),
        'appCode' => env('ALI_APP_CODE'),
    ]
];