<?php

use App\Models\Config;

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

// 前后台登陆
Route::group(['namespace' => 'Auth'], function () {
    Route::get('login', 'LoginController@showLoginForm')->name('login');
    Route::post('login', 'LoginController@login');
    Route::post('logout', 'LoginController@logout')->name('logout');
    Route::get('password/reset', 'ForgotPasswordController@showLinkRequestForm')->name('password.request');
    Route::post('password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('password.email');
    Route::get('password/reset/{token}', 'ResetPasswordController@showResetForm')->name('password.reset');
    Route::post('password/reset', 'ResetPasswordController@reset');
});

// 前台
Route::group(['namespace' => 'Home', 'middleware' => ['check.status']], function () {
    Route::get('/', 'HomeController@index')->name('home');
    Route::get('about', 'HomeController@about')->name('about');
    Route::get('article/{id}', 'HomeController@article')->name('article');
    Route::get('category/{id}', 'HomeController@category')->name('category');
    Route::get('tag/{id}', 'HomeController@tag')->name('tag');
    Route::get('archive', 'HomeController@archive')->name('archive');
    Route::get('message','HomeController@message')->name('message');
    Route::post('message_store','HomeController@message_store')->name('message_store');
    Route::get('search', 'HomeController@search')->name('search');
});
// 后台
Route::group(['namespace' => 'Admin', 'prefix' => 'admin', 'middleware' => ['auth:web','check.timeout']], function () {
    // 控制台
    Route::view('/', 'admin.main.dashboard')->name('dashboard');
    Route::get('home', 'DashboardController@home')->name('admin_home');
    Route::get('clear', 'DashboardController@clear')->name('cache_clear');
    // 配置
    Route::group(['prefix' => 'config'], function () {
        Route::get('manage', 'ConfigController@manage')->name('config_manage');
        Route::post('update', 'ConfigController@update')->name('config_update');
    });
    // 关于
    Route::group(['prefix' => 'about'], function () {
        Route::get('edit', 'ConfigController@editAbout')->name('about_edit');
        Route::post('update', 'ConfigController@updateAbout')->name('about_update');
    });
    // 个人资料
    Route::group(['prefix' => 'profile'], function () {
        Route::get('manage', 'ProfileController@manage')->name('profile_manage');
        Route::post('update_password', 'ProfileController@updatePassword')->name('password_update');
        Route::post('update_profile', 'ProfileController@updateProfile')->name('profile_update');
    });
    // 标签
    Route::group(['prefix' => 'tag'], function () {
        Route::get('manage', 'TagController@manage')->name('tag_manage');
        Route::post('create', 'TagController@store')->name('tag_create');
        Route::get('edit/{id?}', 'TagController@edit')->name('tag_edit');
        Route::post('update', 'TagController@update')->name('tag_update');
        Route::post('destroy', 'TagController@destroy')->name('tag_destroy');
    });
    // 栏目
    Route::group(['prefix' => 'category'], function () {
        Route::get('manage', 'CategoryController@manage')->name('category_manage');
        Route::get('add', 'CategoryController@create')->name('category_add');
        Route::post('create', 'CategoryController@store')->name('category_create');
        Route::get('edit/{id}', 'CategoryController@edit')->name('category_edit');
        Route::post('update/{id}', 'CategoryController@update')->name('category_update');
        Route::post('destroy', 'CategoryController@destroy')->name('category_destroy');
    });
    // 文章
    Route::group(['prefix' => 'article'], function () {
        Route::get('manage', 'ArticleController@manage')->name('article_manage');
        Route::get('add', 'ArticleController@create')->name('article_add');
        Route::post('create', 'ArticleController@store')->name('article_create');
        Route::get('edit/{id}', 'ArticleController@edit')->name('article_edit');
        Route::post('update/{id}', 'ArticleController@update')->name('article_update');
        Route::post('delete', 'ArticleController@destroy')->name('article_delete');
        Route::get('trash', 'ArticleController@trash')->name('article_trash');
        Route::post('restore', 'ArticleController@restore')->name('article_restore');
        Route::post('destroy', 'ArticleController@forceDelete')->name('article_destroy');
    });
    // 友链
    Route::group(['prefix' => 'link'], function () {
        Route::get('manage', 'LinkController@manage')->name('link_manage');
        Route::post('create', 'LinkController@store')->name('link_create');
        Route::get('edit/{id?}', 'LinkController@edit')->name('link_edit');
        Route::post('update', 'LinkController@update')->name('link_update');
        Route::post('destroy', 'LinkController@destroy')->name('link_destroy');
    });
    Route::group(['prefix' => 'message'], function () {
        Route::get('manage', 'MessageController@manage')->name('message_manage');
        Route::get('show/{id?}', 'MessageController@show')->name('message_show');
        Route::post('check', 'MessageController@check')->name('message_check');
        Route::post('reply', 'MessageController@reply')->name('message_reply');
        Route::post('destroy', 'MessageController@destroy')->name('message_destroy');
    });
});
// 关站判断
Route::get('close', function () {
    $status = Config::where('name', 'site_status')->pluck('value')->first();
    if ($status == 0) {
        return view('home.close');
    } else {
        return redirect()->route('home');
    }
})->name('close');
