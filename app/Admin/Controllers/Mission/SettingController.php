<?php

namespace App\Admin\Controllers\Mission;

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
     * @param Settings $model
     * @return Content
     */
    public function index(Settings $model)
    {
        // 直接跳转到对应的配置项
        $setting = $model->where(['name' => 'GET_EXPRESS_SETTING'])->first();

        if (empty($setting)) {
            $setting['id'] = $model->create(['name' => 'GET_EXPRESS_SETTING'])->id;
        }

        return redirect()->action(
            '\\'.config('admin.route.namespace') . '\Mission\SettingController@edit', ['id' => $setting['id']]
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
                $form->currency('price', '收费价格')->rules('required');
                $form->currency('upstairs_price', '送上楼加收价')->rules('required');
                $form->number('credit', '增加积分')->rules('required');
            });

            $form->display('updated_at', '修改时间');

            $form->saved(function() {
                admin_toastr('修改成功', 'success');
                return redirect('/admin/expressSettings');
            });
        });
    }
}
