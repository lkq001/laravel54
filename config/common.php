<?php

return [

    'URL' => [
        'image' =>  env('IMG_PATH'),
    ],
    'system' => [
        'title' => '绿行者'
    ],
    'phone' => [
        'sn' =>  env('PHONE_SN'),
        'pw' =>  env('PHONE_PW'),
        'code' =>  env('PHONE_CODE'),
    ],
    'page' => [
        'number' => env('PAGE_SIZE'),
    ]
];