<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', [
    'namespace' => 'App\Http\Controllers\Api',
    'middleware' => 'serializer:array',
], function ($api) {
    $api->group([
        'middleware' => 'api.throttle',
        'limit' => 5,
        'expires' => 1,
    ], function ($api) {
        //游客接口
        //短信验证码
        $api->post('verificationCodes', 'VerificationCodesController@store')->name('api.verificationCodes.store');

        //用户注册
        $api->post('users', 'UsersController@store')->name('api.users.store');

        //图片验证码
        $api->post('captcha', 'CaptchasController@store')->name('api.captcha.store');

        //第三方登录
        $api->post('socials/{social_type}/authorizations', 'AuthorizationsController@socialStore')->name('api.socials.authorizations.store');

        //用户登录
        $api->post('authorizations', 'AuthorizationsController@store')->name('api.authorizations.store');

        //刷新token
        $api->put('authorizations/current', 'AuthorizationsController@update')->name('api.authorizations.update');

        // 删除token
        $api->delete('authorizations/current', 'AuthorizationsController@destroy')->name('api.authorizations.destroy');

        //需要携带token才能访问的接口,api.auth为dingo自带的中间件
        $api->group(['middleware' => 'api.auth'], function ($api) {
            //当前登录用户信息
            $api->get('user', 'UsersController@show')->name('api.user.show');
            //编辑个人资料
            $api->patch('user','UsersController@update')->name('api.user.update');
            //图片资源
            $api->post('images','ImagesController@store')->name('api.images.store');

        });
    });
});