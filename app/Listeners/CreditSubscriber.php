<?php

namespace App\Listeners;


use App\Models\CreditRecords;
use App\Models\Members;

class CreditSubscriber
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
            'App\Listeners\CreditSubscriber@onPayMissionOrder'
        );

        $events->listen(
            'App\Events\CompletedMissionOrder',
            'App\Listeners\CreditSubscriber@onCompletedMissionOrder'
        );

        $events->listen(
            'App\Events\CancelMissionOrder',
            'App\Listeners\CreditSubscriber@onCancelMissionOrder'
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

        $deductible_fees_credit = $deductible_fees['credit'];
        if (empty($deductible_fees_credit)) {
            return;
        }

        // 计算真实抵扣的积分
        $real_deduction_credit = $deductible_fees_credit * $this->settings['credit_to_money'];

        $member = Members::where('openid', $express->openid)->first();

        $member->credit -= $real_deduction_credit;
        $member->save();

        CreditRecords::create([
            'openid' => $express->openid,
            'action' => '使用积分抵扣',
            'value'  => -$real_deduction_credit,
        ]);

    }

    /**
     * 完成任务,增加用户账上积分
     *
     * @param $event
     */
    public function onCompletedMissionOrder($event)
    {
        $express = $event->missionExpress;

        $member = Members::where('openid', $express->openid)->first();
        $member->credit += $this->settings['reward_credit'];
        $member->save();

        CreditRecords::create([
            'openid' => $express->openid,
            'action' => '完成任务奖励积分',
            'value'  => +$this->settings['reward_credit']
        ]);
    }

    public function onCancelMissionOrder($event)
    {

    }
}