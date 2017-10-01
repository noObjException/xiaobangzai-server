<?php

namespace App\Admin\Controllers\Member;

use App\Models\Staffs;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class StaffController extends Controller
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

            $content->header('配送员管理');

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

            $content->header('配送员管理');

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

            $content->header('配送员管理');

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
        return Admin::grid(Staffs::class, function (Grid $grid) {

            $grid->id('ID')->sortable();

            $grid->column('openid','OPENID')->sortable();
            $grid->column('username', '用户名');
            $grid->column('school', '学校');
            $grid->column('college', '学院');
            $grid->column('student_num', '学号');

            $states = [
                'on'  => [
                    'value' => 1,
                    'text'  => '启用',
                    'color' => 'primary',
                ],
                'off' => [
                    'value' => 0,
                    'text'  => '禁用',
                    'color' => 'default',
                ],
            ];
            $grid->column('status', '审核')->switch($states);

            $grid->created_at('创建时间');
            $grid->updated_at('修改时间');

            $grid->model()->orderBy('id', 'desc');
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(Staffs::class, function (Form $form) {

            $form->display('id', 'ID');

            $form->text('openid','OPENID')
                 ->rules('required');

            $form->text('username', '用户名');

            $form->text('school', '学校');

            $form->text('college', '学院');

            $form->text('student_num', '学号');

            $form->multipleImage('pictures', '学生证照片')
                 ->rules('required');

            $states = [
                'on'  => [
                    'value' => 1,
                    'text'  => '启用',
                    'color' => 'success',
                ],
                'off' => [
                    'value' => 0,
                    'text'  => '禁用',
                    'color' => 'default',
                ],
            ];
            $form->switch('status', '审核')->states($states)->value(1);

            $form->display('created_at', '创建时间');
            $form->display('updated_at', '修改时间');
        });
    }
}
