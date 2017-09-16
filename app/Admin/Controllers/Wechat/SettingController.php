<?php

namespace App\Admin\Controllers\Wechat;

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
     * @return Content
     */
    public function index()
    {
        // 直接跳转到对应的配置项
        $setting = Settings::where(['name' => 'WECHAT_SETTING'])->first();
        return redirect()->action(
            '\\'.config('admin.route.namespace') . '\Wechat\SettingController@edit', ['id' => $setting['id']]
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

            // 转成json格式保存
            $form->embeds('content', '', function ($form) {
                $form->text('app_id')->rules('required');
                $form->text('app_secret')->rules('required');
                $form->text('token')->rules('required');
                $form->text('encodingaeskey')->rules('required');
            });

            $form->display('updated_at', '修改时间');

            $form->saved(function() {
                admin_toastr('修改成功', 'success');
                return redirect('/admin');
            });
        });
    }

}
