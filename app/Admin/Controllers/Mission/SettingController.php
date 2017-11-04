<?php

namespace App\Admin\Controllers\Mission;

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
        $id = Settings::firstOrCreate(['name' => 'GET_EXPRESS_SETTING'])->id;

        return redirect()->action(
            '\\' . config('admin.route.namespace') . '\Mission\SettingController@edit', ['id' => $id]
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
                $states = [
                    'on'  => ['value' => 1, 'text' => '开启', 'color' => 'success',],
                    'off' => ['value' => 0, 'text' => '关闭', 'color' => 'default',],
                ];

                $form->select('base_weight', '基本重量')
                    ->options(ExpressWeights::where(['status' => '1'])->orderBy('sort', 'desc')->pluck('title', 'id'))
                    ->rules('required')
                    ->setWidth(2);

                $form->currency('price', '基本收费')->rules('required');

                $form->switch('switch_overweight_price', '是否开启超重加价')->states($states);
                $form->currency('overweight_price', '超重每KG加价');

                $form->switch('switch_upstairs_price', '是否开启送上楼加价')->states($states);
                $form->currency('upstairs_price', '送上楼加收价');

                $form->switch('switch_reward_point', '是否开启积分奖励')->states($states);
                $form->number('reward_point', '奖励积分');

                $form->switch('switch_point_to_money', '是否开启积分抵扣')->states($states);
                $form->number('point_to_money', '多少积分抵扣1元');

                $form->rate('rate_collect_basic_fees', '基本运费抽成')->setWidth(2)->rules('required');
                $form->rate('rate_collect_extra_fees', '赏金费用抽成')->setWidth(2)->rules('required');

            });

            $form->display('updated_at', '修改时间');

            $form->saved(function () {
                admin_toastr('修改成功', 'success');
            });
        });
    }
}
