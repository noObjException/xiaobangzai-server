<?php

namespace App\Api\V1\Controllers\Wechat;


use App\Api\BaseController;
use App\Models\MissionExpress;
use App\Services\Wechat;
use EasyWeChat\Payment\Order;
use EasyWeChat\Server\BadRequestException;

class PaymentController extends BaseController
{
    public function wxPay()
    {
        $payment = Wechat::app()->payment;

        $order_id = request('order_id');

        $order = MissionExpress::findOrFail($order_id);

        $attributes = [
            'trade_type'   => 'JSAPI', // JSAPI，NATIVE，APP...
            'body'         => $order->express_type . '' . $order->express_weight,
            'detail'       => '代取快递',
            'out_trade_no' => get_order_num('EX'),
            'total_fee'    => $order->total_price * 100, // 单位：分
            'openid'       => current_member_openid(),
        ];

        $order  = new Order($attributes);
        $result = $payment->prepare($order);

        if ($result->return_code == 'SUCCESS' && $result->result_code == 'SUCCESS') {
            $prepayId = $result->prepay_id;

            $data = $payment->configForJSSDKPayment($prepayId);

            return $this->response->array(compact('data'));
        }

        throw new BadRequestException('支付失败');
    }

    public function wxNotify()
    {
        $payment = Wechat::app()->payment;

        $response = $payment->handleNotify(function ($notify, $successful) {
            // 你的逻辑
            info('notify', $notify);

            $order = MissionExpress::where('order_num', $notify->out_trade_no)->first();

            if (!$order) {
                return 'Order not exist.';
            }

            if ($order->pay_time) {
                return true;
            }

            // 用户是否支付成功
            if ($successful) {
                // 不是已经支付状态则修改为已经支付状态
                $order->paid_at = time(); // 更新支付时间为当前时间
                $order->status  = 'paid';
            }

            $order->save();

            return true;
        });

        return $response;
    }
}