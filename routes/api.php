<?php


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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});
Route::any('/wechat', 'App\Api\WechatController@serve');

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', [
    'namespace' => 'App\Api\V1\Controllers'
], function ($api) {

    $api->resource('/index', 'IndexController');
    $api->resource('/members', 'MemberController');

    $api->get('/schoolAreas', 'MemberAddressController@chooseAreas');
    $api->resource('/memberAddress', 'MemberAddressController');

    // 任务(取快递, 等...)
    $api->group(['namespace' => 'Mission'], function ($api) {

        $api->get('/getExpress/initData', 'ExpressController@getInitData');
        $api->get('/getExpress/initInfoData', 'ExpressController@getInitInfoData');

        $api->resource('/getExpress', 'ExpressController');
    });
});