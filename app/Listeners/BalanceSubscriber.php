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
    }

    public function onCompletedMissionOrder($event)
    {
        $express = $event->missionExpress;
        if ($express->status !== order_status_to_num('COMPLETED')) {
            return;
        }

        // 计算给配送员的余额
        $balance = $express->price * (1 - $this->express_settings['rate_collect_basic_fees'] / 100)
                + ($express->total_price - $express->price) * (1 - $this->express_settings['rate_collect_extra_fees'] / 100);

        $staffModel = Members::where('openid', $express->accept_order_openid)->first();

        $staffModel->increment('balance', $balance);

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
            "first"    => ["恭喜你购买成功！", '#555555'],
            "keynote1" => ["巧克力", "#336699"],
            "keynote2" => ["39.8元", "#FF0000"],
            "keynote3" => ["2014年9月16日", "#888888"],
            "remark"   => ["欢迎再次购买！", "#5599FF"],
        ];
        $url         = '';

        if ($template_id) {
            SendWechatTemplateMessage::dispatch($express->accept_order_openid, $template_id, $data, $url);
        } else {
            SendWechatTextMessage::dispatch($express->openid, '余额到账'.$balance.'元');
        }
    }
}