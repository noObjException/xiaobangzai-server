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
    'namespace' => 'App\Api\V1\Controllers',
], function ($api) {


    $api->resource('/index', 'IndexController');


    // 任务(取快递, 等...)
    $api->group(['namespace' => 'Mission'], function ($api) {

        $api->resource('/getExpress', 'ExpressController');

        // 订单流程
        $api->get('/expressMission/index', 'OrderController@index');
        $api->get('/expressMission/create', 'OrderController@create');
        $api->put('/expressMission/pay/{id}', 'OrderController@pay');
        $api->put('/expressMission/completed/{id}', 'OrderController@completed');
        $api->put('/expressMission/addBounty/{id}', 'OrderController@addBounty');
        $api->put('/expressMission/cancel/{id}', 'OrderController@cancel');
        $api->put('/expressMission/acceptOrder/{id}', 'OrderController@acceptOrder');
    });

    $api->group(['namespace' => 'Member'], function ($api) {

        $api->get('/schoolAreas', 'AddressController@chooseAreas');
        $api->resource('/members', 'MemberController');
        $api->resource('/memberAddress', 'AddressController');

        $api->get('/creditRecords/{openid}', 'CreditRecordController@index');

    });

    $api->group(['namespace' => 'Common'], function ($api) {

        $api->post('/pictures', 'PictureController@store');
        $api->get('/authMember', 'AuthMemberController@authMember')->middleware('jwt.auth');

    });

    $api->group(['namespace' => 'Staff'], function ($api) {

        $api->resource('/staffs', 'StaffController');
        $api->get('/missions', 'MissionController@index');

    });
});