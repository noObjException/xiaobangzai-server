<?php

namespace App\Admin\Controllers\Show;

use App\Models\Navs;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class NavController extends Controller
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

            $content->header('导航菜单');

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

            $content->header('导航菜单');

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

            $content->header('导航菜单');

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
        return Admin::grid(Navs::class, function (Grid $grid) {

            $grid->id('ID')->sortable();

            $grid->column('title','菜单名')->sortable();
            $grid->column('image', '图片')->image('', 40, 40);
            $grid->column('url', '链接');

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
                $filter->between('created_at', 'Created Time')->datetime();
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
        return Admin::form(Navs::class, function (Form $form) {

            $form->display('id', 'ID');

            $form->text('title','菜单名');
            $form->image('image','图片');
            $form->text('url', '链接');
            $form->number('sort', '排序');
            $form->switch('status', '状态');

            $form->display('created_at', '创建时间');
            $form->display('updated_at', '修改时间');
        });
    }
}
