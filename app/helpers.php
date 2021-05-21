<?php

use App\Models\Category;
use App\Models\Product;

if (! function_exists('primary_menu')) {
    function primary_menu() {
        return Category::parents();
    }
}

if (! function_exists('price')) {
    function price($text) {
        return number_format($text, 0).'đ';
    }
}


