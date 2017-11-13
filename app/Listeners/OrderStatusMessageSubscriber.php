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
            $address     = json_decode($express->address, true);

            $data        = [
                "first"    => ['您已经成功接单，请及时派送!'],
                "keyword1" => [$express->order_num],
                "keyword2" => [$express->express_option . '/' . $express->pickup_code ?: ''],
                "keyword3" => [$address['realname']],
                "keyword4" => [$express->staff->mobile],
                "keyword5" => [$address['college'] . ' ' . $address['area'] . ' ' . $address['detail'] ?: ''],
            ];

            $url = client_url('staff/mission/detail?id=' . $express->id);

            $template_id = $this->settings['accept_order_to_staff'];
            if ($template_id) {
                SendWechatTemplateMessage::dispatch($express->accept_order_openid, $template_id, $data, $url);
            } else {
                SendWechatTextMessage::dispatch($express->accept_order_openid, '您好, 欢迎接单!<br>欢迎再来!');
            }
        }

        // 发给下单人
        if ($this->settings['switch_accept_order_to_member']) {
            $express     = $event->missionExpress;

            $data        = [
                'first'    => ['尊我们已经接到你的订单啦，派送过程中请保持手机畅通哦。'],
                'keyword1' => [$express->order_num],
                'keyword2' => [$express->staff->realname],
                'keyword3' => [$express->staff->mobile],
                'remark'   => ['如有疑问请与配送人员联系'],
            ];

            $url = client_url('member/mission/detail?id=' . $express->id);

            $template_id = $this->settings['accept_order_to_member'];
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

        $data        = [
            'first'    => ['您的订单已经确认收货'],
            'keyword1' => [$express->order_num],
            'keyword2' => [$express->express_option],
            'keyword3' => [$express->created_at->toDateTimeString()],
            'keyword4' => [$express->start_time],
            'keyword5' => [$express->finish_time],
            'remark'   => ['感谢您的支持，如有疑问请与客服联系：17687629508'],
        ];

        $url = client_url('member/mission/detail?id=' . $express->id);

        $template_id = $this->settings['completed_order'];
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
            'first'    => ['您的订单已经取消成功!'],
            'keyword1' => [$express->order_num],
            'keyword2' => ['取消'],
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