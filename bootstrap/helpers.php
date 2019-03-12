<?php
/**
 * Created by PhpStorm.
 * User: Marc Yin
 * Date: 2019-03-07
 * Time: 18:35
 */

function route_class()
{
    return str_replace('.', '-', Route::currentRouteName());
}

function make_excerpt($value, $length = 200)
{
    $excerpt = trim(preg_replace('/\r\n|\r|\n+/', ' ', strip_tags($value)));
    return str_limit($excerpt, $length);
}