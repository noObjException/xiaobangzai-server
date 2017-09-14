<?php

namespace App\Admin\Controllers\Show;

use App\Models\Notices;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class NoticeController extends Controller
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

            $content->header('滚动公告');

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

            $content->header('滚动公告');

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

            $content->header('滚动公告');

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
        return Admin::grid(Notices::class, function (Grid $grid) {

            $grid->id('ID')->sortable();

            $grid->column('title','标题')->sortable();
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
                $filter->like('name', '公告栏标题');
                $filter->between('created_at', '创建时间')->datetime();
                $filter->between('updated_at', '修改时间')->datetime();});
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(Notices::class, function (Form $form) {

            $form->display('id', 'ID');

            $form->text('title','标题')
                 ->rules('required');

            $form->url('url', '链接');

            $form->number('sort', '排序')
                ->default(0)
                ->help('数字越大排名越靠前');

            $form->editor('content', '内容');

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

            $form->display('created_at', '创建时间');
            $form->display('updated_at', '修改时间');
        });
    }
}
