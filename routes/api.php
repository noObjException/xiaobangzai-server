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



    // 任务(取快递, 等...)
    $api->group(['namespace' => 'Mission'], function ($api) {

        $api->get('/getExpress/initData', 'ExpressController@getInitData');
        $api->get('/getExpress/initInfoData', 'ExpressController@getInitInfoData');
        $api->resource('/getExpress', 'ExpressController');

        // 支付
        $api->put('/getExpress/pay/{id}', 'OrderController@pay');
        $api->put('/getExpress/completed/{id}', 'OrderController@completed');
        $api->put('/getExpress/cancel/{id}', 'OrderController@cancel');
    });

    $api->group(['namespace' => 'Member'], function ($api) {

        $api->get('/schoolAreas', 'AddressController@chooseAreas');
        $api->resource('/members', 'MemberController');
        $api->resource('/memberAddress', 'AddressController');

    });
});