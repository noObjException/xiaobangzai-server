<?php

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

Route::redirect('/', config('admin.route.prefix'));

Route::any('/wechat', 'WechatController@serve');
Route::any('/wxapp', 'WechatController@wxapp');

Route::get('/token', 'WechatController@token')->middleware('wechatOAuth');
Route::get('/api/wxappToken', 'WechatController@wxappToken');




