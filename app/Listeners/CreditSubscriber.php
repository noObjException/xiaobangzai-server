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

    public function onPayMissionOrder($event)
    {
        $express = $event->missionExpress;
        if ($express->status !== order_status_to_num('WAIT_ORDER')) {
            return;
        }

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

    public function onCompletedMissionOrder($event)
    {

    }

    public function onCancelMissionOrder($event)
    {

    }
}