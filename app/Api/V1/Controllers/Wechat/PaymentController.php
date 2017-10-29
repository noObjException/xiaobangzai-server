<?php
namespace App\Api\V1\Controllers\Wechat;


use App\Api\BaseController;
use App\Services\Wechat;
use EasyWeChat\Payment\Order;
use EasyWeChat\Server\BadRequestException;

class PaymentController extends BaseController
{
    public function wxPay()
    {
        $payment = Wechat::app()->payment;

        $attributes = [
            'trade_type'       => 'JSAPI', // JSAPI，NATIVE，APP...
            'body'             => 'iPad mini 16G 白色',
            'detail'           => 'iPad mini 16G 白色',
            'out_trade_no'     => '1217752501201407033233368018',
            'total_fee'        => 5388, // 单位：分
            'openid'           => current_member_openid(), // trade_type=JSAPI，此参数必传，用户在商户appid下的唯一标识，
            // ...
        ];

        $order = new Order($attributes);

        $result = $payment->prepare($order);
        if ($result->return_code == 'SUCCESS' && $result->result_code == 'SUCCESS'){
            $prepayId = $result->prepay_id;

            $data = $payment->configForJSSDKPayment($prepayId);

            return $this->response->array(compact('data'));
        }

        throw new BadRequestException('支付失败');
    }

    public function wxNotify()
    {
        $payment = Wechat::app()->payment;

        $response = $payment->handleNotify(function($notify, $successful){
            // 你的逻辑
            info('notify', json_encode($notify));
            info('$successful', json_encode($successful));

            return true; // 或者错误消息
        });

        return $response;
    }
}