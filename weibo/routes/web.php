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

/**
 * 首页相关route
 */
Route::get('/', 'StaticPagesController@home')->name('home');
Route::get('/help', 'StaticPagesController@help')->name('help');
Route::get('/about', 'StaticPagesController@about')->name('about');
Route::get('/test', 'StaticPagesController@test')->name('test');

/**
 * user资源相关route
 */
Route::get('/signup', 'UsersController@create')->name('signup');
Route::resource('users', 'UsersController');

/**
 * login会话控制
 */
Route::get('login', 'SessionsController@create')->name('login');
Route::post('login', 'SessionsController@store')->name('login');
Route::delete('logout', 'SessionsController@destroy')->name('logout');

/**
 * email验证
 */
Route::get('signup/confirm/{token}', 'UsersController@confirmEmail')->name('confirm_email');

/**
 * statuses resource
 */
Route::resource('statuses', 'StatusesController', ['only' => ['store', 'destroy']]);


/**
 * follow
 */
Route::get('/users/{user}/followings', 'UsersController@followings')->name('followings');
Route::get('/users/{user}/followings', 'UsersController@followers')->name('users.followers');
Route::post('/users/followers/{user}', 'FollowersController@store')->name('followers.store');
Route::delete('/users/followers/{user}', 'FollowersController@destroy')->name('followers.destroy');
