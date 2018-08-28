<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// 后台登陆
Route::group(['namespace' => 'Auth'], function () {
    Route::get('login', 'LoginController@showLoginForm')->name('login');
    Route::post('login', 'LoginController@login');
    Route::post('logout', 'LoginController@logout')->name('logout');
    Route::get('password/reset', 'ForgotPasswordController@showLinkRequestForm')->name('password.request');
    Route::post('password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('password.email');
    Route::get('password/reset/{token}', 'ResetPasswordController@showResetForm')->name('password.reset');
    Route::post('password/reset', 'ResetPasswordController@reset');
    // 第三方登录
    Route::group(['prefix' => 'oauth'], function () {
        // 重定向
        Route::get('redirect/{service}', 'OAuthController@redirectToProvider')->name('oauth.redirect');
        // 获取用户资料并登录
        Route::get('callback/{service}', 'OAuthController@handleProviderCallback')->name('oauth.callback');
        // 退出登录
        Route::get('logout', 'OAuthController@logout');
    });
    Route::post('hook/{type}','HookController@push');
});

// 前台
Route::group(['namespace' => 'Home', 'middleware' => ['check.status']], function () {
    Route::get('/', 'HomeController@index')->name('home');
    Route::get('about', 'HomeController@about')->name('about');
    Route::get('article/{id}', 'HomeController@article')->name('article');
    Route::get('page/{id}', 'HomeController@page')->name('page');
    Route::post('comment_store','HomeController@comment_store')->name('comment_store');
    Route::get('category/{id}', 'HomeController@category')->name('category');
    Route::get('tag/{id}', 'HomeController@tag')->name('tag');
    Route::get('archive', 'HomeController@archive')->name('archive');
    Route::get('message','HomeController@message')->name('message');
    Route::post('message_store','HomeController@message_store')->name('message_store');
    Route::get('subscribe','HomeController@subscribe')->name('subscribe');
    Route::post('subscribe_store','HomeController@subscribe_store')->name('subscribe_store');
    Route::get('search', 'HomeController@search')->name('search');
});
Route::group(['namespace' => 'Api', 'prefix'=>'api','middleware' => ['check.status','throttle:10']], function () {
    Route::get('qrcode', 'QrcodeController@generate');
    Route::get('qrcode_decode', 'QrcodeController@decode');
});
// 后台
Route::group(['namespace' => 'Admin', 'prefix' => 'admin', 'middleware' => ['auth:web','check.timeout','check.permission']], function () {
    // 权限管理
    Route::group(['namespace' => 'Permission'],function(){
        // 角色
        Route::group(['prefix' => 'role'],function(){
            Route::get('manage', 'RoleController@manage')->name('role_manage');
            Route::post('store', 'RoleController@store')->name('role_store');
            Route::get('edit/{id}', 'RoleController@edit')->name('role_edit');
            Route::post('update/{id}', 'RoleController@update')->name('role_update');
            Route::post('destroy', 'RoleController@destroy')->name('role_destroy');
            Route::get('search', 'RoleController@search')->name('role_search');
        });
        // 权限
        Route::group(['prefix' => 'permission'],function(){
            Route::get('manage', 'PermissionController@manage')->name('permission_manage');
            Route::post('store', 'PermissionController@store')->name('permission_store');
            Route::get('edit/{id?}', 'PermissionController@edit')->name('permission_edit');
            Route::post('update', 'PermissionController@update')->name('permission_update');
            Route::post('destroy', 'PermissionController@destroy')->name('permission_destroy');
            Route::get('search', 'PermissionController@search')->name('permission_search');
        });
        // 用户
        Route::group(['prefix' => 'user'],function(){
            Route::get('manage', 'UserController@manage')->name('user_manage');
            Route::get('create', 'UserController@create')->name('user_create');
            Route::post('store', 'UserController@store')->name('user_store');
            Route::get('edit/{id}', 'UserController@edit')->name('user_edit');
            Route::post('update/{id}', 'UserController@update')->name('user_update');
            Route::post('delete', 'UserController@delete')->name('user_delete');
            Route::get('trash', 'UserController@trash')->name('user_trash');
            Route::post('restore', 'UserController@restore')->name('user_restore');
            Route::post('destroy', 'UserController@destroy')->name('user_destroy');
            Route::get('search', 'UserController@search')->name('user_search');
        });
    });
    // 控制台
    Route::get('/', function(){
        return redirect()->route('dashboard_home');
    });
    Route::get('home', 'DashboardController@home')->name('dashboard_home');
    Route::get('clear', 'DashboardController@clear')->name('cache_clear');
    // 配置
    Route::group(['prefix' => 'config'], function () {
        Route::get('manage', 'ConfigController@manage')->name('config_manage');
        Route::post('update', 'ConfigController@update')->name('config_update');
    });
    // 个人资料
    Route::group(['prefix' => 'profile'], function () {
        Route::get('manage', 'ProfileController@manage')->name('profile_manage');
        Route::post('uploadAvatar', 'ProfileController@uploadAvatar')->name('avatar_upload');
        Route::post('updatePassword', 'ProfileController@updatePassword')->name('password_update');
        Route::post('updateProfile', 'ProfileController@updateProfile')->name('profile_update');
        Route::post('unbindThirdLogin', 'ProfileController@unbindThirdLogin')->name('unbind_third_login');
    });
    // 标签
    Route::group(['prefix' => 'tag'], function () {
        Route::get('manage', 'TagController@manage')->name('tag_manage');
        Route::post('store', 'TagController@store')->name('tag_store');
        Route::get('edit/{id?}', 'TagController@edit')->name('tag_edit');
        Route::post('update', 'TagController@update')->name('tag_update');
        Route::post('destroy', 'TagController@destroy')->name('tag_destroy');
        Route::get('search', 'TagController@search')->name('tag_search');
    });
    // 栏目
    Route::group(['prefix' => 'category'], function () {
        Route::get('manage', 'CategoryController@manage')->name('category_manage');
        Route::get('create', 'CategoryController@create')->name('category_create');
        Route::post('store', 'CategoryController@store')->name('category_store');
        Route::get('edit/{id}', 'CategoryController@edit')->name('category_edit');
        Route::post('update/{id}', 'CategoryController@update')->name('category_update');
        Route::post('destroy', 'CategoryController@destroy')->name('category_destroy');
    });
    // 菜单
    Route::group(['prefix' => 'nav'], function () {
        Route::get('manage', 'NavController@manage')->name('nav_manage');
        Route::get('create', 'NavController@create')->name('nav_create');
        Route::post('store', 'NavController@store')->name('nav_store');
        Route::get('edit/{id}', 'NavController@edit')->name('nav_edit');
        Route::post('update/{id}', 'NavController@update')->name('nav_update');
        Route::post('destroy', 'NavController@destroy')->name('nav_destroy');
    });
    // 文章
    Route::group(['prefix' => 'article'], function () {
        Route::get('manage', 'ArticleController@manage')->name('article_manage');
        Route::get('create', 'ArticleController@create')->name('article_create');
        Route::post('store', 'ArticleController@store')->name('article_store');
        Route::get('edit/{id}', 'ArticleController@edit')->name('article_edit');
        Route::post('update/{id}', 'ArticleController@update')->name('article_update');
        Route::post('delete', 'ArticleController@delete')->name('article_delete');
        Route::get('trash', 'ArticleController@trash')->name('article_trash');
        Route::post('restore', 'ArticleController@restore')->name('article_restore');
        Route::post('destroy', 'ArticleController@destroy')->name('article_destroy');
    });
    // 单页
    Route::group(['prefix' => 'page'], function () {
        Route::get('manage', 'PageController@manage')->name('page_manage');
        Route::get('create', 'PageController@create')->name('page_create');
        Route::post('store', 'PageController@store')->name('page_store');
        Route::get('edit/{id}', 'PageController@edit')->name('page_edit');
        Route::post('update/{id}', 'PageController@update')->name('page_update');
        Route::post('delete', 'PageController@delete')->name('page_delete');
        Route::get('trash', 'PageController@trash')->name('page_trash');
        Route::post('restore', 'PageController@restore')->name('page_restore');
        Route::post('destroy', 'PageController@destroy')->name('page_destroy');
    });
    // 评论
    Route::group(['prefix' => 'comment'], function () {
        Route::get('manage', 'CommentController@manage')->name('comment_manage');
        Route::get('show/{id?}', 'CommentController@show')->name('comment_show');
        Route::post('check', 'CommentController@check')->name('comment_check');
        Route::post('reply', 'CommentController@reply')->name('comment_reply');
        Route::post('destroy', 'CommentController@destroy')->name('comment_destroy');
    });
    // 友链
    Route::group(['prefix' => 'link'], function () {
        Route::get('manage', 'LinkController@manage')->name('link_manage');
        Route::post('store', 'LinkController@store')->name('link_store');
        Route::get('edit/{id?}', 'LinkController@edit')->name('link_edit');
        Route::post('update', 'LinkController@update')->name('link_update');
        Route::post('destroy', 'LinkController@destroy')->name('link_destroy');
    });
    // 留言
    Route::group(['prefix' => 'message'], function () {
        Route::get('manage', 'MessageController@manage')->name('message_manage');
        Route::get('show/{id?}', 'MessageController@show')->name('message_show');
        Route::post('check', 'MessageController@check')->name('message_check');
        Route::post('reply', 'MessageController@reply')->name('message_reply');
        Route::post('destroy', 'MessageController@destroy')->name('message_destroy');
    });
    // 操作日志
    Route::group(['prefix' => 'operation_logs'], function () {
        Route::get('manage', 'OperationLogsController@manage')->name('operation_logs_manage');
        Route::post('destroy', 'OperationLogsController@destroy')->name('operation_logs_destroy');
    });
    Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');
    // 图床
    Route::group(['prefix' => 'image'],function(){
        Route::get('list', 'ImageController@list')->name('image_list');
        Route::post('upload', 'ImageController@upload')->name('image_upload');
    });
    // 订阅
    Route::group(['prefix' => 'subscribe'], function () {
        Route::get('manage', 'SubscribeController@manage')->name('subscribe_manage');
        Route::post('destroy', 'SubscribeController@destroy')->name('subscribe_destroy');
        Route::post('push', 'SubscribeController@push')->name('subscribe_push');
    });
});
// 测试路由
Route::get('/test', function () {
    return '测试页面';
})->name('test');

