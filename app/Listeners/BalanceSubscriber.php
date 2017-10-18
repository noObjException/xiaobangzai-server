<?php

namespace App\Listeners;


use App\Jobs\SendWechatTemplateMessage;
use App\Jobs\SendWechatTextMessage;
use App\Models\Members;

class BalanceSubscriber
{
    protected $settings;

    public function __construct()
    {
        $this->settings = get_setting('GET_EXPRESS_SETTING');
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
        $express = $event->express;
        if ($express !== order_status_to_num('COMPLETED')) {
            return;
        }

        $balance = $express->price * (1 - $this->settings['rate_collect_basic_fees'] / 100)
                + ($express->total_price - $express->price) * (1 - $this->settings['rate_collect_extra_fees'] / 100);

        $staffModel = Members::where('openid', $express->accept_order_openid)->first();

        $staffModel->increment('balance', $balance);

        if ($this->settings['switch_balance_to_account']) {
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
        $template_id = $this->settings['create_order'];
        $data        = [
            "first"    => ["恭喜你购买成功！", '#555555'],
            "keynote1" => ["巧克力", "#336699"],
            "keynote2" => ["39.8元", "#FF0000"],
            "keynote3" => ["2014年9月16日", "#888888"],
            "remark"   => ["欢迎再次购买！", "#5599FF"],
        ];
        $url         = '';

        if ($template_id) {
            SendWechatTemplateMessage::dispatch($express->openid, $template_id, $data, $url);
        } else {
            SendWechatTextMessage::dispatch($express->openid, '余额到账'.$balance.'元');
        }
    }
}