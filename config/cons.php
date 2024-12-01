<?php

$default_pic = "/media/media_fixed/logo_holder.png";

# 1039381 -- тестовый, 1043605 -- товары на продажу

$yc_shops = [
    [
        'order' => 1,
        'name' => 'Авиторов 21',
        'id' => 247576,
        'storage_id' => ENV('APP_DEBUG') ? 1039381 : 1043605,
        'good_for_sell_parent_category' => 481179,
        'abonement_category' => 479138,
        'sert_category' => 445497
    ],
    [
        'order' => 2,
        'name' => 'Бограда 105',
        'id' => 921995,
        'storage_id' => ENV('APP_DEBUG') ? 2174746 : 1857399,
        'good_for_sell_parent_category' => 1389938,
        'abonement_category' => 1178599,
        'sert_category' => 1178598
    ]

];

return [
    'telegram_chat_id' => ENV('APP_DEBUG') ? "2174746" : '4272894582',
    'default_pic' => $default_pic,
    'yc_shops' => $yc_shops
];
