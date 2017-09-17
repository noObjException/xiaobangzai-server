<?php

namespace App\Admin\Controllers\Member;

use App\Models\MemberGroups;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class GroupController extends Controller
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

            $content->header('会员分组');
            

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

            $content->header('会员分组');
           

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

            $content->header('会员分组');

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
        return Admin::grid(MemberGroups::class, function (Grid $grid) {

            $grid->id('ID')->sortable();

            $grid->column('title', '组名');

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

            $grid->model()->orderBy('id', 'desc');

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
        return Admin::form(MemberGroups::class, function (Form $form) {

            $form->display('id', 'ID');

            $form->text('title', '分组名');
            $form->number('sort', '排序');

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
