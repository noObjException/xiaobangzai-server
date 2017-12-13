<?php

namespace App\Admin\Controllers\Member;

use App\Models\Balances;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class BalanceController extends Controller
{
    use ModelForm;

    /**
     * Index interface.
     *
     * @return Content
     */
    public function index()
    {
        return Admin::content(function (Content $content) {

            $content->header('余额提现申请');

            $content->body($this->grid());
        });
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Admin::grid(Balances::class, function (Grid $grid) {

            $grid->disableCreation();

            $grid->id('ID')->sortable();

            $grid->column('member.avatar', '头像')->image('', 40, 40);
            $grid->column('member.nickname', '申请人');
            $grid->column('remaining_balance', '当前余额');
            $grid->column('cash_balance', '申请提现');

            $grid->column('status', '审核状态')->display(function () {
                $status = $this->status;
                if ($status == -1) {
                    return '<span class="label label-danger">不通过</span>';
                }
                if ($status == 1) {
                    return '<span class="label label-success">通过</span>';
                }
                if ($status == 2) {
                    return '<span class="label label-warning">已到账</span>';
                }
                return '<span class="label label-primary,">待审核</span>';
            });

            $grid->created_at('申请时间');

            $grid->actions(function ($actions) {
                $actions->disableDelete();
                $actions->disableEdit();
            });
        });
    }
}
