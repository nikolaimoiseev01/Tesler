<?php

$default_pic = "/media/media_fixed/logo_holder.png";

$yc_shops = [
    [
        'order' => 1,
        'name' => 'Авиторов 21',
        'id' => 247576
    ],
    [
        'order' => 2,
        'name' => 'Бограда 105',
        'id' => 921995
    ]

];

return [
    'telegram_chat_id' => ENV('APP_DEBUG') ? "-4272894582" : '-4262760917',
    'default_pic' => $default_pic,
    'yc_shops' => $yc_shops
];
