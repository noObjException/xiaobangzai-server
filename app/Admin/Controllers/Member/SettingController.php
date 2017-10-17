<?php

namespace App\Admin\Controllers\Member;

use App\Models\ExpressWeights;
use App\Models\Settings;

use Encore\Admin\Form;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class SettingController extends Controller
{
    use ModelForm;

    /**
     * Index interface.
     *
     */
    public function index()
    {
        $id = Settings::firstOrCreate(['name' => 'MEMBER_SETTING'])->id;

        return redirect()->action(
            '\\' . config('admin.route.namespace') . '\Member\SettingController@edit', ['id' => $id]
        );
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

            $content->header('基本设置');

            $content->body($this->form()->edit($id));
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(Settings::class, function (Form $form) {
            $form->disableReset();
            $form->tools(function (Form\Tools $tools) {
                // 去掉返回按钮
                $tools->disableBackButton();
                // 去掉跳转列表按钮
                $tools->disableListButton();
            });

            $form->embeds('content', '', function ($form) {

                $states = [
                    'on'  => ['value' => 1, 'text' => '开启', 'color' => 'success',],
                    'off' => ['value' => 0, 'text' => '关闭', 'color' => 'default',],
                ];

                $form->switch('switch_member_identify', '学生认证')->states($states);
                $form->switch('switch_staff_identify', '配送员认证')->states($states);

            });

            $form->display('updated_at', '修改时间');

            $form->saved(function () {
                admin_toastr('修改成功', 'success');
                //                return redirect('/admin/expressSettings');
            });
        });
    }
}
