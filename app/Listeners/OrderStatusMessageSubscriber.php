<?php

namespace App\Listeners;


use App\Jobs\SendWechatTemplateMessage;
use App\Jobs\SendWechatTextMessage;

class OrderStatusMessageSubscriber
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
            'App\Listeners\OrderStatusMessageSubscriber@onCreateMissionOrder'
        );

        $events->listen(
            'App\Events\PayMissionOrder',
            'App\Listeners\OrderStatusMessageSubscriber@onPayMissionOrder'
        );

        $events->listen(
            'App\Events\AcceptMissionOrder',
            'App\Listeners\OrderStatusMessageSubscriber@onAcceptMissionOrder'
        );

        $events->listen(
            'App\Events\CompletedMissionOrder',
            'App\Listeners\OrderStatusMessageSubscriber@onCompletedMissionOrder'
        );

        $events->listen(
            'App\Events\CancelMissionOrder',
            'App\Listeners\OrderStatusMessageSubscriber@onCancelMissionOrder'
        );
    }

    public function onCreateMissionOrder($event)
    {
        if (empty($this->settings['switch_create_order'])) {
            return;
        }

        $express     = $event->missionExpress;
        $template_id = $this->settings['create_order'];
        $address     = json_decode($express->address, true);
        $data        = [
            'first'    => ['下单成功！'],
            'keyword1' => [$express->order_num],
            'keyword2' => ['￥ ' . $express->total_price],
            'keyword3' => [$address['realname']],
            'keyword4' => [$address['mobile']],
            'keyword5' => [$address['college'] . ' ' . $address['area'] . ' ' . $address['detail']],
            'remark'   => ['请核对信息后支付! '],
        ];

        $url = client_url('member/mission/detail?id=' . $express->id);

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

        $data = [
            'first'    => ['支付成功！'],
            'keyword1' => [$express->member->nickname],
            'keyword2' => [$express->order_num],
            'keyword3' => ['￥ ' . $express->total_price],
            'keyword4' => [$express->express_type . ' ' . $express->weight],
            'remark'   => [''],
        ];

        $url = client_url('member/mission/detail?id=' . $express->id);

        if ($template_id) {
            SendWechatTemplateMessage::dispatch($express->openid, $template_id, $data, $url);
        } else {
            SendWechatTextMessage::dispatch($express->openid, '您好, 欢迎付款!<br>欢迎再来!');
        }
    }

    public function onAcceptMissionOrder($event)
    {
        // 发给接单人
        if ($this->settings['switch_accept_order_to_staff']) {
            $express     = $event->missionExpress;
            $template_id = $this->settings['accept_order_to_staff'];
            $address     = json_decode($express->address, true);
            $data        = [
                "first"    => ['您已成功接单!'],
                "keyword1" => [$express->order_num],
                "keyword2" => [$express->express_type . ' ' . $express->weight],
                "keyword3" => [$address['realname']],
                "keyword4" => [$address['college'] . ' ' . $address['area'] . ' ' . $address['detail']],
                "keyword5" => ['成功!'],
                "remark"   => ['请' . $express->arrive_time . '送达'],
            ];

            $url = client_url('staff/mission/detail?id=' . $express->id);

            if ($template_id) {
                SendWechatTemplateMessage::dispatch($express->accept_order_openid, $template_id, $data, $url);
            } else {
                SendWechatTextMessage::dispatch($express->accept_order_openid, '您好, 欢迎接单!<br>欢迎再来!');
            }
        }

        // 发给下单人
        if ($this->settings['switch_accept_order_to_member']) {
            $express     = $event->missionExpress;
            $template_id = $this->settings['accept_order_to_member'];
            $data        = [
                'first'    => ['尊敬的【' . $express->member->nickname . '】，您的需求有人接单，点击查看详情'],
                'keyword1' => [$express->order_num],
                'keyword2' => [$express->start_time],
                'remark'   => ['您可以跟配送员联系沟通'],
            ];

            $url = client_url('member/mission/detail?id=' . $express->id);

            if ($template_id) {
                SendWechatTemplateMessage::dispatch($express->openid, $template_id, $data, $url);
            } else {
                SendWechatTextMessage::dispatch($express->openid, '您好, 已有人接单!<br>欢迎再来!');
            }
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
            'first'    => ['尊敬的【' . $express->member->nickname . '】，您的订单已完成'],
            'keyword1' => [$express->order_num],
            'keyword2' => [$express->finish_time],
            'remark'   => ['欢迎再次使用我们的服务!'],
        ];

        $url = client_url('member/mission/detail?id=' . $express->id);

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
            'first'    => ['您的订单已取消!'],
            'keyword1' => [$express->order_num],
            'keyword2' => ['取快递'],
            'keyword3' => ['￥ ' . $express->total_price],
            'keyword4' => [$express->updated_at],
            'keyword5' => [$express->member->nickname],
        ];

        $url = client_url('member/mission/detail?id=' . $express->id);

        if ($template_id) {
            SendWechatTemplateMessage::dispatch($express->openid, $template_id, $data, $url);
        } else {
            SendWechatTextMessage::dispatch($express->openid, '您好, 欢迎取消!<br>欢迎再来!');
        }
    }
}