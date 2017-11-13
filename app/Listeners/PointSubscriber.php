<?php

namespace App\Listeners;


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
    }

    public function onCancelMissionOrder($event)
    {

    }
}