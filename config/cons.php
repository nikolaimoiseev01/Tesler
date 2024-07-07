<?php

$default_pic = "/media/media_fixed/logo_holder.png";

# 1039381 -- тестовый, 1043605 -- товары на продажу

$yc_shops = [
    [
        'order' => 1,
        'name' => 'Авиторов 21',
        'id' => 247576,
        'storage_id' => ENV('APP_DEBUG') ? "1039381" : '1043605'
    ],
    [
        'order' => 2,
        'name' => 'Бограда 105',
        'id' => 921995,
        'storage_id' => ENV('APP_DEBUG') ? "2174746" : '1857399'
    ]

];

return [
    'telegram_chat_id' => ENV('APP_DEBUG') ? "2174746" : '1857399',
    'default_pic' => $default_pic,
    'yc_shops' => $yc_shops
];
