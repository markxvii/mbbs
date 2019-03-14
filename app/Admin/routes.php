<?php

use App\Admin\Controllers\UsersController;
use Illuminate\Routing\Router;

Admin::registerAuthRoutes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', 'HomeController@index');
    //User
    $router->get('users', 'UsersController@index');
    //Topic
    $router->get('topics', 'TopicsController@index');
    $router->get('topics/{id}/edit', 'TopicsController@edit');
    $router->put('topics/{id}', 'TopicsController@update');
    $router->delete('topics/{id}', 'TopicsController@destroy');
    //Reply
    $router->get('replies', 'RepliesController@index');
    $router->get('replies/{id}/edit', 'RepliesController@edit');
    $router->put('replies/{id}', 'RepliesController@update');
    $router->delete('replies/{id}', 'RepliesController@destroy');
    //Category
    $router->get('categories', 'CategoriesController@index');
});
