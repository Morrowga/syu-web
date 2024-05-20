<?php

if (! function_exists('generateRandomString')) {
    function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';
        $max = strlen($characters) - 1;

        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $max)];
        }

        return $randomString;
    }
}

if (! function_exists('calculate_product_price')) {
    function calculate_product_price(int $size,int $quality) {
        return $size + $quality;
    }
}
