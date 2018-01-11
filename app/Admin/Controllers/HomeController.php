<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Members;
use App\Models\MissionExpress;
use Encore\Admin\Controllers\Dashboard;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Column;
use Encore\Admin\Layout\Content;
use Encore\Admin\Layout\Row;
use Encore\Admin\Widgets\Box;
use Encore\Admin\Widgets\InfoBox;
use Encore\Admin\Widgets\Table;
use Illuminate\Support\Carbon;

class HomeController extends Controller
{
    public function index()
    {
        return Admin::content(function (Content $content) {

            $content->header('Dashboard');
            $content->description('Description...');

            $content->row(function ($row) {
                $row->column(3, new InfoBox('今日新增用户', 'users', 'aqua', 'members', Members::today()->count()));
                $row->column(3, new InfoBox('今日新增订单', 'shopping-cart', 'green', 'express', MissionExpress::today()->count()));
                $row->column(3, new InfoBox('会员总数', 'car', 'yellow', 'members', Members::count()));
                $row->column(3, new InfoBox('订单总数', 'file', 'red', 'express', MissionExpress::count()));
            });

            $content->row(function (Row $row) {

                $row->column(4, function (Column $column) {
                    $column->append(Dashboard::environment());
                });

                $row->column(4, function (Column $column) {
                    $column->append(Dashboard::extensions());
                });

                $row->column(4, function (Column $column) {
                    $column->append(Dashboard::dependencies());
                });
            });
        });
    }
}
