<?php

// Function to filter array by ID
function filterById($array, $id) {
    return current(array_filter($array, function($item) use ($id) {
        return $item['id'] == $id;
    }));
}

function getShopById($id) {
    $shops = config('cons.yc_shops');
    return current(array_filter($shops, function($item) use ($id) {
        return $item['id'] == $id;
    }));
}
