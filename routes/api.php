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

    // 支付
    $api->put('/getExpress/pay/{id}', 'PayController@update');

    // 任务(取快递, 等...)
    $api->group(['namespace' => 'Mission'], function ($api) {

        $api->get('/getExpress/initData', 'ExpressController@getInitData');
        $api->get('/getExpress/initInfoData', 'ExpressController@getInitInfoData');
        $api->resource('/getExpress', 'ExpressController');
    });

    $api->group(['namespace' => 'Member'], function ($api) {

        $api->get('/memberMissions/{openid}/{status?}', 'MissionController@index');
        $api->resource('/members', 'MemberController');
        $api->get('/schoolAreas', 'AddressController@chooseAreas');
        $api->resource('/memberAddress', 'AddressController');

    });
});