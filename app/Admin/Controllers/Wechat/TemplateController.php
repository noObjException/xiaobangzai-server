<?php

namespace App\Admin\Controllers\Wechat;


use App\Http\Controllers\Controller;
use App\Models\Settings;
use Encore\Admin\Controllers\ModelForm;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Form;
use Encore\Admin\Layout\Content;

class TemplateController extends Controller
{
    use ModelForm;

    /**
     * Index interface.
     *
     */
    public function index()
    {
        // 直接跳转到对应的配置项
        $id = Settings::firstOrCreate(['name' => 'TEMPLATE_MESSAGE_SETTING'])->id;

        return redirect()->action(
            '\\' . config('admin.route.namespace') . '\Wechat\TemplateController@edit', ['id' => $id]
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
                $tools->disableBackButton();
                $tools->disableListButton();
            });

            // 转成json格式保存
            $form->embeds('content', '', function ($form) {
                $state = [
                    'on'  => ['value' => 1, 'text' => '开启', 'color' => 'success',],
                    'off' => ['value' => 0, 'text' => '关闭', 'color' => 'default',],
                ];

                $form->switch('switch_create_order', '下单成功通知开关(发给下单人)')->states($state);
                $form->text('create_order', '下单成功通知模板id')->help('编号: ??');

                $form->switch('switch_pay_order', '付款成功通知开关(发给下单人)')->states($state);
                $form->text('pay_order', '付款成功通知模板id')->help('编号: OPENTM207498902');

                $form->switch('switch_accept_order_to_staff', '送货员接单提醒开关(发给配送员)')->states($state);
                $form->text('accept_order_to_staff', '送货员接单提醒模板id')->help('编号: OPENTM401560056');

                $form->switch('switch_accept_order_to_member', '接单成功通知开关(发给下单人)')->states($state);
                $form->text('accept_order_to_member', '接单成功通知模板id')->help('编号: OPENTM401560056');

                $form->switch('switch_completed_order', '订单完成通知开关(发给下单人)')->states($state);
                $form->text('completed_order', '订单完成通知模板id')->help('编号: OPENTM202314085');

                $form->switch('switch_cancel_order', '订单取消通知开关(发给下单人)')->states($state);
                $form->text('cancel_order', '订单取消通知模板id')->help('编号: OPENTM207618730');

                $form->switch('switch_refund_to_account', '退款成功通知开关(发给下单人)')->states($state);
                $form->text('refund_to_account', '退款成功通知模板id')->help('编号: TM00430');

                $form->switch('switch_point_to_account', '账户积分变动通知开关(发给下单人)')->states($state);
                $form->text('point_to_account', '账户积分变动通知模板id')->help('编号: OPENTM207509450');

                $form->switch('switch_balance_to_account', '账户余额变动通知开关(发给下单人)')->states($state);
                $form->text('balance_to_account', '账户余额变动通知模板id')->help('编号: OPENTM401833445');
            });

            $form->saved(function () {
                admin_toastr('修改成功', 'success');

                return redirect(admin_url('/wechatTemplates'));
            });
        });
    }
}