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

$api = app('Dingo\Api\Routing\Router');


$api->version('v1', [
    'namespace'  => 'App\Api\V1\Controllers',
], function ($api) {

    // 微信支付回调通知, 不经过jwt中间件
    $api->post('/wxNotify', 'Mission\OrderController@wxNotify');


    $api->group(['middleware' => ['jwt.auth']], function ($api) {
        $api->resource('/index', 'IndexController');


        // 任务(取快递, 等...)
        $api->group(['namespace' => 'Mission'], function ($api) {

            $api->get('/getExpress/create', 'ExpressController@create');
            $api->resource('/getExpress', 'ExpressController');

            // 订单流程
            $api->get('/expressMission/index', 'OrderController@index');
            $api->get('/expressMission/create', 'OrderController@create');
            $api->post('/expressMission/wxPay', 'OrderController@wxPay');
            $api->put('/expressMission/completed/{id}', 'OrderController@completed');
            $api->put('/expressMission/addBounty/{id}', 'OrderController@addBounty');
            $api->put('/expressMission/cancel/{id}', 'OrderController@cancel');
            $api->put('/expressMission/acceptOrder/{id}', 'OrderController@acceptOrder');
        });

        $api->group(['namespace' => 'Member'], function ($api) {

            $api->get('/schoolAreas', 'AddressController@chooseAreas');
            $api->get('/members', 'MemberController@show');

            $api->get('/memberAddress/create', 'AddressController@create');
            $api->put('/setDefaultAddress/{id}', 'AddressController@setDefaultAddress');
            $api->resource('/memberAddress', 'AddressController');

            $api->get('/pointRecords', 'PointRecordController@index');

            $api->post('/member/identifys', 'IdentifyController@store');

        });

        $api->group(['namespace' => 'Common'], function ($api) {

            $api->resource('/pictures', 'PictureController');
            $api->get('/authMember', 'AuthMemberController@authMember');

        });

        $api->group(['namespace' => 'Staff'], function ($api) {

            $api->resource('/staffs', 'StaffController');
            $api->get('/missions', 'MissionController@index');

        });

        $api->group(['namespace' => 'Wechat'], function ($api) {

            $api->get('/jsSDKConfig', 'JSSDKController@getConfig');

        });
    });

});