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