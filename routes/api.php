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
    'middleware' => ['serializer:array', 'bindings','change-locale']
], function ($api) {
    $api->group([
        'middleware' => 'api.throttle',
        'limit' => 100,
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

        //分类接口
        $api->get('categories', 'CategoriesController@index')->name('api.categories.index');

        //话题列表
        $api->get('topics', 'TopicsController@index')->name('api.topics.index');

        //话题详情
        $api->get('topics/{topic}', 'TopicsController@show')->name('api.topics.show');

        //帖子回复列表
        $api->get('topics/{topic}/replies', 'RepliesController@index')->name('api.replies.index');

        //用户回复列表
        $api->get('users/{user}/replies', 'RepliesController@userIndex')->name('api.replies.userIndex');

        // 资源推荐
        $api->get('links', 'LinksController@index')->name('api.links.index');

        // 活跃用户
        $api->get('users/actived', 'UsersController@activedIndex')->name('api.users.activedIndex');

        //需要携带token才能访问的接口,api.auth为dingo自带的中间件
        $api->group(['middleware' => 'api.auth'], function ($api) {
            //当前登录用户信息
            $api->get('user', 'UsersController@show')->name('api.user.show');
            //编辑个人资料
            $api->patch('user', 'UsersController@update')->name('api.user.update');

            //图片资源
            $api->post('images', 'ImagesController@store')->name('api.images.store');

            //发布话题
            $api->post('topics', 'TopicsController@store')->name('api.topics.store');
            //修改话题
            $api->patch('topics/{topic}', 'TopicsController@update')->name('api.topics.update');
            //删除话题
            $api->delete('topics/{topic}', 'TopicsController@destroy')->name('api.topics.destroy');

            //发表回复
            $api->post('replies', 'RepliesController@store')->name('api.replies.store');
            //删除回复
            $api->delete('replies/{reply}', 'RepliesController@destroy')->name('api.replies.destroy');

            //通知列表
            $api->get('users/notifications', 'NotificationsController@index')->name('api.notifications.index');

            //通知统计
            $api->get('users/notifications/status', 'NotificationsController@stats')->name('api.notifications.stats');
            // 标记消息通知为已读
            $api->patch('users/notifications', 'NotificationsController@read')->name('api.notifications.read');
        });
    });
});