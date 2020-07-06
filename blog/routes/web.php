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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/blog/{blog}', 'BlogController@getBlogById');
Route::post('/blog/{blog}', 'BlogController@postOne');
Route::delete('/blog/{blog}', 'BlogController@deleteBlogById');
Route::put('/blog/{blog}', 'BlogController@putOne');
