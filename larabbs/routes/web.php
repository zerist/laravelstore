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

Route::get('/', 'PagesController@root')->name('root');
Route::get('welcome', 'PagesController@welcome')->name('welcome');

// 用户身份验证相关的路由
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

// 用户注册相关路由
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');

// 密码重置相关路由
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');

// Email 认证相关路由
Route::get('email/verify', 'Auth\VerificationController@show')->name('verification.notice');
Route::get('email/verify/{id}/{hash}', 'Auth\VerificationController@verify')->name('verification.verify');
Route::post('email/resend', 'Auth\VerificationController@resend')->name('verification.resend');

//users 相关
Route::resource('users', 'UsersController', ['only'=>['show', 'update', 'edit']]);


//topic 相关
Route::prefix('topics')->group(function () {
    Route::get('/', 'TopicsController@index')->name('topics.index');
    Route::get('{topic}/{slug?}', 'TopicsController@show')->name('topics.show')->where('topic', '[0-9]+');
    Route::get('create/{topic?}', 'TopicsController@create')->name('topics.create');
    Route::post('/', 'TopicsController@store')->name('topics.store');
    Route::put('{topic}', 'TopicsController@update')->name('topics.update');
    Route::post('upload_image', 'TopicsController@uploadImage')->name('topics.upload_image');
    Route::delete('{topic}', 'TopicsController@destroy')->name('topics.destroy');
});


//category 相关
Route::resource('categories', 'CategoriesController', ['only' => ['show']]);

//reply 相关
Route::resource('replies', 'RepliesController')->only(['show', 'store', 'destroy']);

//notification 相关
Route::resource('notifications', 'NotificationsController', ['only' => ['index']]);
