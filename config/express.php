<?php
/**
 * @author caojiayuan
 */

return [
    'default' => env('EXPRESS_DRIVER', 'kdniao'),

    'kdniao' => [
        'ebussionsid' => env('KDNIAO_EBUSSIONSID', ''),
        'appKey'      => env('KDNIAO_APPKEY', ''),
    ]
];