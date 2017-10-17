<?php

namespace App\Listeners;


use App\Jobs\SendWechatTemplateMessage;
use App\Jobs\SendWechatTextMessage;

class SendTemplateMessageSubscriber
{
    protected $settings;

    public function __construct()
    {
        $this->settings = get_setting('TEMPLATE_MESSAGE_SETTING');
    }

    public function subscribe($events)
    {
        $events->listen(
            'App\Events\CreateMissionOrder',
            'App\Listeners\SendTemplateMessageSubscriber@onCreateMissionOrder'
        );

        $events->listen(
            'App\Events\PayMissionOrder',
            'App\Listeners\SendTemplateMessageSubscriber@onPayMissionOrder'
        );

        $events->listen(
            'App\Events\AcceptMissionOrder',
            'App\Listeners\SendTemplateMessageSubscriber@onAcceptMissionOrder'
        );

        $events->listen(
            'App\Events\CompletedMissionOrder',
            'App\Listeners\SendTemplateMessageSubscriber@onCompletedMissionOrder'
        );

        $events->listen(
            'App\Events\CancelMissionOrder',
            'App\Listeners\SendTemplateMessageSubscriber@onCancelMissionOrder'
        );
    }

    public function onCreateMissionOrder($event)
    {
        if (empty($this->settings['switch_create_order'])) {
            return;
        }

        $express     = $event->missionExpress;
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
            SendWechatTextMessage::dispatch($express->openid, '您好, 欢迎购买!<br>欢迎再来!');
        }

    }

    public function onPayMissionOrder($event)
    {
        if (empty($this->settings['switch_pay_order'])) {
            return;
        }

        $express     = $event->missionExpress;
        $template_id = $this->settings['pay_order'];
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
            SendWechatTextMessage::dispatch($express->openid, '您好, 欢迎付款!<br>欢迎再来!');
        }
    }

    public function onAcceptMissionOrder($event)
    {
        if (empty($this->settings['switch_accept_order'])) {
            return;
        }

        $express     = $event->missionExpress;
        $template_id = $this->settings['accept_order'];
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
            SendWechatTextMessage::dispatch($express->openid, '您好, 欢迎接单!<br>欢迎再来!');
        }
    }

    public function onCompletedMissionOrder($event)
    {
        if (empty($this->settings['switch_completed_order'])) {
            return;
        }

        $express     = $event->missionExpress;
        $template_id = $this->settings['completed_order'];
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
            SendWechatTextMessage::dispatch($express->openid, '您好, 完成订单!<br>欢迎再来!');
        }
    }

    public function onCancelMissionOrder($event)
    {
        if (empty($this->settings['switch_cancel_order'])) {
            return;
        }

        $express     = $event->missionExpress;
        $template_id = $this->settings['cancel_order'];
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
            SendWechatTextMessage::dispatch($express->openid, '您好, 欢迎取消!<br>欢迎再来!');
        }
    }
}