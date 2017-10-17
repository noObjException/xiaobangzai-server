<?php

namespace App\Listeners;


use App\Jobs\SendWechatTemplateMessage;

class SendTemplateMessageSubscriber
{
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
    }

    public function onCreateMissionOrder($event)
    {
        $express     = $event->missionExpress;
        $template_id = '';
        $data        = [
            "first"    => ["恭喜你购买成功！", '#555555'],
            "keynote1" => ["巧克力", "#336699"],
            "keynote2" => ["39.8元", "#FF0000"],
            "keynote3" => ["2014年9月16日", "#888888"],
            "remark"   => ["欢迎再次购买！", "#5599FF"],
        ];
        $url         = '';
        SendWechatTemplateMessage::dispatch($express->openid, $template_id, $data, $url);
    }

    public function onPayMissionOrder($event)
    {
        $express     = $event->missionExpress;
        $template_id = '';
        $data        = [
            "first"    => ["恭喜你购买成功！", '#555555'],
            "keynote1" => ["巧克力", "#336699"],
            "keynote2" => ["39.8元", "#FF0000"],
            "keynote3" => ["2014年9月16日", "#888888"],
            "remark"   => ["欢迎再次购买！", "#5599FF"],
        ];
        $url         = '';
        SendWechatTemplateMessage::dispatch($express->openid, $template_id, $data, $url);
    }
}