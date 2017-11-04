<?php

use Illuminate\Routing\Router;

Admin::registerAuthRoutes();

Route::group([
                 'prefix'     => config('admin.route.prefix'),
                 'namespace'  => config('admin.route.namespace'),
                 'middleware' => config('admin.route.middleware'),
             ], function (Router $router) {

    $router->get('/', 'HomeController@index');

    // 首页内容设置
    $router->group(['namespace' => 'Show'], function ($router) {

        $router->resource('/swipers', 'SwiperController');
        $router->resource('/navs', 'NavController');
        $router->resource('/notices', 'NoticeController');
        $router->resource('/cubes', 'CubeController');

    });

    // 微信相关设置
    $router->group(['namespace' => 'Wechat'], function ($router) {

        $router->resource('/wechatMenus', 'MenuController');
        $router->resource('/wechatSettings', 'SettingController');
        $router->get('/setWechatMenus', 'MenuController@setMenu');
        $router->resource('/wechatTemplates', 'TemplateController');

    });

    // 会员管理
    $router->group(['namespace' => 'Member'], function ($router) {

        $router->resource('/members', 'MemberController');
        $router->resource('/memberGroups', 'GroupController');
        $router->resource('/memberLevels', 'LevelController');
        $router->resource('/pointRecords', 'PointRecordController');
        $router->resource('/staffs', 'StaffController');
        $router->resource('/memberSettings', 'SettingController');

    });

    // 设置部分
    $router->group(['namespace' => 'Setting'], function($router) {

        $router->resource('/expressTypes', 'ExpressTypeController');
        $router->resource('/expressWeights', 'ExpressWeightController');
        $router->resource('/expressCompanys', 'ExpressCompanyController');
        $router->resource('/arriveTimes', 'ArriveTimeController');
        $router->resource('/schoolAreas', 'SchoolAreaController');
        $router->resource('/schools', 'SchoolController');

    });

    // 任务相关设置
    $router->group(['namespace' => 'Mission'], function($router) {

        $router->resource('/express', 'ExpressController');
        $router->resource('/expressSettings', 'SettingController');
        $router->put('/expressPay/{id}', 'OrderController@pay');
        $router->put('/assignOrder/{id}', 'OrderController@assignOrder');

    });
});
