<?php

use App\Models\Setting;
use Illuminate\Support\Facades\File;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

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
    function calculate_product_price(int $size,int $quality,int $qty) {
        return ($size + $quality) * $qty;
    }
}


if (! function_exists('calculate_source_price_per_product')) {
    function calculate_source_price_per_product(int $size,int $quality) {
        return $size + $quality;
    }
}

if (! function_exists('calculate_price_per_product')) {
    function calculate_price_per_product(int $size,int $quality) {
        return $size + $quality;
    }
}



if (! function_exists('generateQR')) {
    function generateQR()
    {

    }
}

