<?php

namespace App\Listeners;


use App\Jobs\SendWechatTemplateMessage;
use App\Jobs\SendWechatTextMessage;
use App\Models\Members;

class BalanceSubscriber
{
    protected $template_settings;

    protected $express_settings;

    public function __construct()
    {
        $this->template_settings = get_setting('TEMPLATE_MESSAGE_SETTING');
        $this->express_settings = get_setting('GET_EXPRESS_SETTING');
    }

    public function subscribe($events)
    {
        $events->listen(
            'App\Events\CompletedMissionOrder',
            'App\Listeners\BalanceSubscriber@onCompletedMissionOrder'
        );

        $events->listen(
            'App\Events\PayMissionOrder',
            'App\Listeners\BalanceSubscriber@onPayMissionOrder'
        );
    }

    /**
     * 计算给配送员的余额
     *
     * @param $event
     */
    public function onPayMissionOrder($event)
    {
        $express = $event->missionExpress;

        $to_staff_money = $express->price * (1 - $this->express_settings['rate_collect_basic_fees'] / 100)
                        + ($express->total_price - $express->price) * (1 - $this->express_settings['rate_collect_extra_fees'] / 100);

        $express->to_staff_money = $to_staff_money;

        $express->save();
    }

    /**
     * 增加余额到配送员的账上,并发消息通知
     *
     * @param $event
     */
    public function onCompletedMissionOrder($event)
    {
        $express = $event->missionExpress;

        $balance = $express->to_staff_money;

        $staffModel = Members::where('openid', $express->accept_order_openid)->first();

        $staffModel->balance += $balance;

        $staffModel->save();

        if ($this->template_settings['switch_balance_to_account']) {
            $this->sendBalanceToAccountMessage($express, $balance);
        }
    }

    /**
     * 余额到账提醒
     *
     * @param $express
     * @param $balance
     */
    protected function sendBalanceToAccountMessage($express, $balance)
    {
        $template_id = $this->template_settings['balance_to_account'];
        $data        = [
            'first'    => ['恭喜您获得完成任务获得余额奖励!'],
            'keyword1' => [$express->updated_at],
            'keyword2' => ['￥ ' . $express->to_staff_money],
            'keyword3' => ['￥ ' . $express->member->balance],
            'remark'   => ['余额可提现和兑换积分'],
        ];
        $url         = '';

        if ($template_id) {
            SendWechatTemplateMessage::dispatch($express->accept_order_openid, $template_id, $data, $url);
        } else {
            SendWechatTextMessage::dispatch($express->accept_order_openid, '余额到账'.$balance.'元');
        }
    }
}