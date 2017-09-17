<?php

namespace App\Admin\Controllers\Setting;

use App\Models\SchoolAreas;

use Encore\Admin\Form;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Column;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use Encore\Admin\Layout\Row;
use Encore\Admin\Tree;
use Encore\Admin\Widgets\Box;

class SchoolAreaController extends Controller
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
            $content->header('营业范围');

            $content->row(function (Row $row) {
                $row->column(6, $this->treeView()->render());

                $row->column(6, function (Column $column) {
                    $form = new \Encore\Admin\Widgets\Form();
                    $form->action(admin_url('schoolAreas'));

                    $form->number('sort', '排序');
                    $form->select('pid', '上级')->options(SchoolAreas::selectOptions());
                    $form->text('title', '名字')->rules('required');

                    $column->append((new Box('添加', $form))->style('success'));
                });
            });
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

            $content->header('营业范围');

            $content->body($this->form()->edit($id));
        });
    }

    private function treeView() {
        return SchoolAreas::tree(function (Tree $tree) {
            $tree->disableCreate();

            $tree->branch(function ($branch) {
                $payload = "&nbsp;<strong>{$branch['title']}</strong>";

                return $payload;
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
        return Admin::form(SchoolAreas::class, function (Form $form) {

            $form->display('id', 'ID');

            $form->number('sort', '排序');
            $form->select('pid', '上级')->options(SchoolAreas::selectOptions());
            $form->text('title', '名字')->rules('required');

            $form->display('created_at', '创建时间');
            $form->display('updated_at', '修改时间');
        });
    }
}
