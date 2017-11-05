<?php

namespace App\Admin\Controllers\Member;

use App\Admin\Extensions\Identify;
use App\Models\MemberIdentifies;

use App\Models\Members;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class IdentifyController extends Controller
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

            $content->header('认证申请列表');

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

            $content->header('详情信息');

            $content->body($this->form()->edit($id));
        });
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Admin::grid(MemberIdentifies::class, function (Grid $grid) {
            $grid->disableCreation();

            $grid->column('member.nickname', '昵称');
            $grid->column('username', '姓名');
            $grid->column('school', '学校');
            $grid->column('college', '学院');
            $grid->column('study_no', '学号');

            $grid->actions(function ($actions) {
                $actions->disableDelete();

                $actions->append(new Identify($actions->row->openid));
            });

            $grid->model()
                ->orderByDesc('member_identifies.id')
                ->leftJoin('members', 'members.openid', '=', 'member_identifies.openid')
                ->where('members.is_identify', '0');

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
        return Admin::form(MemberIdentifies::class, function (Form $form) {


            $form->display('id', 'ID');

            $form->display('member.nickname', '昵称');
            $form->display('username', '姓名');
            $form->display('school', '学校');
            $form->display('college', '学院');
            $form->display('study_no', '学号');

            $form->multipleImage('pictures', '证件照');

            $form->display('created_at', '创建时间');
            $form->display('updated_at', '修改时间');
        });
    }

    public function passIdentify($id)
    {
        if (Members::where('openid', $id)->update(['is_identify' => 1])) {
            $status  = true;
            $message = '认证成功!';
        } else {
            $status  = false;
            $message = '认证失败!';
        }

        return response()->json([
            'status'  => $status,
            'message' => $message,
        ]);
    }
}
