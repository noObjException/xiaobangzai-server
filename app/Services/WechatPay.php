<?php
namespace App\Services;


use App\Models\MissionExpress;
use EasyWeChat\Payment\Order;

class WechatPay
{
    protected $model;

    public function __construct(MissionExpress $model)
    {
        $this->model = $model;
    }

    public function make()
    {
        $model = $this->model;

        $payment = Wechat::app()->payment;

        $attributes = [
            'trade_type'   => 'JSAPI', // JSAPI，NATIVE，APP...
            'body'         => '代取快递收费',
            'out_trade_no' => $model->order_num,
            'total_fee'    => $model->total_price * 100, // 单位：分
            'openid'       => current_member_openid(),
        ];

        $order  = new Order($attributes);
        $result = $payment->prepare($order);

        if ($result->return_code == 'SUCCESS' && $result->result_code == 'SUCCESS') {
            $prepayId = $result->prepay_id;

            return $payment->configForJSSDKPayment($prepayId);
        }

        return false;
    }
}