<?php

namespace App\Api\V1\Controllers\Wechat;


use App\Api\BaseController;
use App\Models\MissionExpress;
use App\Services\Wechat;
use EasyWeChat\Payment\Order;
use EasyWeChat\Server\BadRequestException;

class PaymentController extends BaseController
{
    /**
     * 微信支付
     *
     * @return mixed
     * @throws BadRequestException
     */
    public function wxPay()
    {
        $payment = Wechat::app()->payment;

        $order_id = request('order_id');

        $order = MissionExpress::findOrFail($order_id);

        $attributes = [
            'trade_type'   => 'JSAPI', // JSAPI，NATIVE，APP...
            'body'         => $order->express_type . '' . $order->express_weight,
            'detail'       => '代取快递',
            'out_trade_no' => $order->order_num,
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

    /**
     * 微信支付回调
     *
     * $notify 类型为collect集合(不是json), 内容:
     *  {
     *      "appid": "wxbb60510a67a531e2",
     *      "bank_type": "CMB_CREDIT",
     *      "cash_fee": "2",
     *      "fee_type": "CNY",
     *      "is_subscribe": "Y",
     *      "mch_id": "1348273001",
     *      "nonce_str": "59f9bc5ecd028",
     *      "openid": "o-TvDv1GYB2DG3Fazuu580gKnOrk",
     *      "out_trade_no": "EX20171101202183704",
     *      "result_code": "SUCCESS",
     *      "return_code": "SUCCESS",
     *      "sign": "3621E51ECECB52B77324018E1F5A714D",
     *      "time_end": "20171101202156",
     *      "total_fee": "2",
     *      "trade_type": "JSAPI",
     *      "transaction_id": "4200000012201711011779695596"
     *  }
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function wxNotify()
    {
        $payment = Wechat::app()->payment;

        $response = $payment->handleNotify(function ($notify, $successful) {

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
                $order->pay_time = date('Y-m-d H:i:s'); // 更新支付时间为当前时间
                $order->status  = 1;
            }

            $order->save();

            return true;
        });

        return $response;
    }
}