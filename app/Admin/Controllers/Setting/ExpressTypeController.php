<?php

namespace App\Admin\Controllers\Setting;

use App\Models\ExpressTypes;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class ExpressTypeController extends Controller
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

            $content->header('快递物品类型');

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

            $content->header('快递物品类型');

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

            $content->header('快递物品类型');

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
        return Admin::grid(ExpressTypes::class, function (Grid $grid) {

            $grid->id('ID')->sortable();

            $grid->column('name','名字')->sortable();

            $states = [
                'on'  => [
                    'value' => 1,
                    'text'  => '显示',
                    'color' => 'primary',
                ],
                'off' => [
                    'value' => 0,
                    'text'  => '隐藏',
                    'color' => 'default',
                ],
            ];
            $grid->column('status', '是否显示')->switch($states);

            $grid->created_at('创建时间');
            $grid->updated_at('修改时间');

            $grid->model()->orderBy('id', 'desc');

            // filter($callback)方法用来设置表格的简单搜索框
            $grid->filter(function ($filter) {

                // 设置created_at字段的范围查询
                $filter->like('name', '名字');
                $filter->between('created_at', '创建时间')->datetime();
                $filter->between('updated_at', '修改时间')->datetime();
            });
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(ExpressTypes::class, function (Form $form) {

            $form->display('id', 'ID');

            $form->text('name','名字')
                ->rules('required');

            $form->number('sort', '排序')
                ->default(0)
                ->help('数字越大排名越靠前');

            $states = [
                'on'  => [
                    'value' => 1,
                    'text'  => '显示',
                    'color' => 'success',
                ],
                'off' => [
                    'value' => 0,
                    'text'  => '隐藏',
                    'color' => 'default',
                ],
            ];
            $form->switch('status', '是否显示')->states($states)->value(1);

            $form->display('created_at', 'Created At');
            $form->display('updated_at', 'Updated At');
        });
    }
}
