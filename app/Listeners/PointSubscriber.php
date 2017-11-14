<?php

namespace App\Listeners;


use App\Jobs\SendWechatTemplateMessage;
use App\Jobs\SendWechatTextMessage;
use App\Models\PointRecords;
use App\Models\Members;

class PointSubscriber
{
    protected $settings;

    public function __construct()
    {
        $this->settings = get_setting('GET_EXPRESS_SETTING');
    }

    public function subscribe($events)
    {
        $events->listen(
            'App\Events\PayMissionOrder',
            'App\Listeners\PointSubscriber@onPayMissionOrder'
        );

        $events->listen(
            'App\Events\CompletedMissionOrder',
            'App\Listeners\PointSubscriber@onCompletedMissionOrder'
        );

        $events->listen(
            'App\Events\CancelMissionOrder',
            'App\Listeners\PointSubscriber@onCancelMissionOrder'
        );
    }

    /**
     * 减掉用户账上用于抵扣的积分, 并记录
     *
     * @param $event
     */
    public function onPayMissionOrder($event)
    {
        $express = $event->missionExpress;

        $deductible_fees = json_decode($express->deductible_fees, true);

        $deductible_fees_point = $deductible_fees['point'];
        if (empty($deductible_fees_point)) {
            return;
        }

        // 计算真实抵扣的积分
        $real_deduction_point = $deductible_fees_point * $this->settings['point_to_money'];

        $member = Members::where('openid', $express->openid)->first();

        $member->point -= $real_deduction_point;
        $member->save();

        PointRecords::create([
            'openid' => $express->openid,
            'action' => '使用积分抵扣',
            'value'  => -$real_deduction_point,
        ]);
    }

    /**
     * 完成任务,增加用户账上积分
     *
     * @param $event
     */
    public function onCompletedMissionOrder($event)
    {
        if (empty($this->settings['switch_reward_point'])) {
            return;
        }

        $express = $event->missionExpress;

        $member         = Members::where('openid', $express->openid)->first();
        $member->point += $this->settings['reward_point'];
        $member->save();

        PointRecords::create([
            'openid' => $express->openid,
            'action' => '完成任务奖励积分',
            'value'  => +$this->settings['reward_point'],
        ]);

        $this->sendTemplateMessage($express, $this->settings['reward_point']);
    }

    public function onCancelMissionOrder($event)
    {

    }


    protected function sendTemplateMessage($express, $point)
    {
        if (empty($this->settings['switch_point_to_account'])) {
            return;
        }

        $express     = $express->missionExpress;
        $template_id = $this->settings['cancel_order'];
        $data        = [
            'first'    => ['亲爱的'. $express->member->nickname .'，您的积分账户有新的变动，具体内容如下：'],
            'keyword1' => [$express->created_at->toDateTimeString()],
            'keyword2' => [$point],
            'keyword3' => ['完成交易'],
            'keyword4' => [$express->member->point],
            'remark'   => ['感谢您的支持。']
        ];

        $url = client_url('member/point');

        if ($template_id) {
            SendWechatTemplateMessage::dispatch($express->openid, $template_id, $data, $url);
        } else {
            SendWechatTextMessage::dispatch($express->openid, '您好, 欢迎取消!<br>欢迎再来!');
        }
    }
}