<?php

namespace App\Admin\Controllers\Mission;

use App\Models\MissionExpress;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class ExpressController extends Controller
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

            $content->header('任务');

            $content->body($this->grid());
        });
    }

    /**
     * Edit interface.
     *
     * @param $id
     * @return Content
     */
    public function edit($id)
    {
        return Admin::content(function (Content $content) use ($id) {

            $content->header('任务');

            $content->body($this->form()->edit($id));
        });
    }

    /**
     * Create interface.
     *
     * @return Content
     */
    public function create()
    {
        return Admin::content(function (Content $content) {

            $content->header('任务');

            $content->body($this->form());
        });
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Admin::grid(MissionExpress::class, function (Grid $grid) {

            $grid->id('ID')->sortable();

            $grid->column('realname', '真实姓名');
            $grid->column('nickname', '昵称');
            $grid->column('mobile', '手机号');
            $grid->column('credit', '积分');
            $grid->column('balance', '余额');
            $grid->column('avatar', '头像');

            $grid->created_at('创建时间');
            $grid->updated_at('修改时间');
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(MissionExpress::class, function (Form $form) {

            $form->display('id', 'ID');

            $form->display('openid', 'OPENID');
            $form->display('order_num', '订单号');
            $form->display('price', '费用');
            $form->display('total_price', '总费用');
            $form->display('pay_type', '支付方式');
            $form->display('status', '状态');
            $form->display('remark', '备注');
            $form->display('bounty', '赏金');
            $form->display('pay_time', '支付时间');

            $form->display('created_at', '创建时间');
            $form->display('updated_at', '修改时间');
        });
    }
}
