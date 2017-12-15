<?php

namespace App\Api\V1\Controllers\Mission;


use App\Api\BaseController;
use App\Events\AcceptMissionOrder;
use App\Events\CancelMissionOrder;
use App\Events\CompletedMissionOrder;
use App\Events\PayMissionOrder;
use App\Models\MissionExpress;
use App\Services\WechatPay;
use Dingo\Api\Exception\UpdateResourceFailedException;
use Dingo\Api\Http\Request;
use EasyWeChat\Kernel\Exceptions\BadRequestException;
use Illuminate\Support\Carbon;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

/**
 * 处理任务订单的支付, 接单, 追加赏金, 完成任务等功能
 *
 * Class OrderController
 * @package App\Api\V1\Controllers\Mission
 */
class OrderController extends BaseController
{
    protected $model;

    public function __construct(MissionExpress $model)
    {
        $this->model = $model;
    }

    /**
     * 支付订单
     *
     * @param Request $request
     * @return \Dingo\Api\Http\Response
     */
    public function wxPay(Request $request)
    {
        $settings = get_setting('GET_EXPRESS_SETTING');

        $order_id     = $request->get('order_id');
        $is_use_point = $request->get('is_use_point', false);

        $expressModel = $this->model->findOrFail($order_id);

        // 计算积分抵扣
        if ($is_use_point && $settings['switch_point_to_money']) {
            $point     = $expressModel->member->point;
            $deduction = number_format($point / $settings['point_to_money'], 2);

            if ($deduction > $expressModel->total_price) {
                $deduction = $expressModel->total_price;
            }

            $expressModel->total_price -= $deduction;

            $deductible_fees = ['point' => $deduction];

            $expressModel->deductible_fees = json_encode($deductible_fees);
        }

        throw_unless($expressModel->save(), new UpdateResourceFailedException('支付失败, 请稍候重试!'));

        $pay = new WechatPay($expressModel);

        throw_unless($data = $pay->make(), new BadRequestException('支付错误!'));

        return $this->response->array(compact('data'));


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
        $payment = WechatPay::payment();

        $response = $payment->handlePaidNotify(function ($message, $fail) {

            $order = MissionExpress::where('order_num', $message['out_trade_no'])->first();

            if (!$order) {
                $fail('Order not exist.');
            }

            if ($order->pay_time) {
                return true;
            }

            // 用户是否支付成功
            if ($message['result_code'] === 'SUCCESS') {
                // 不是已经支付状态则修改为已经支付状态
                $order->pay_time       = Carbon::now();
                $order->status         = 1;
                $order->pay_type       = 'WECHAT_PAY';
                $order->arrived_amount = $message['total_fee'] / 100;
            }

            if ($order->save() && $order->status === order_status_to_num('WAIT_ORDER')) {
                event(new PayMissionOrder($order));
            }

            return true;
        });

        return $response;
    }

    /**
     * 完成订单
     *
     * @param $id
     * @return \Dingo\Api\Http\Response
     * @internal param MissionExpress $this ->model
     */
    public function completed($id)
    {
        $expressModel = $this->model->findOrFail($id);

        throw_if($expressModel->openid !== current_member_openid(), new UpdateResourceFailedException('无法完成不是你的订单!'));

        $expressModel->finish_time = Carbon::now();
        $expressModel->status      = 3;

        throw_unless($expressModel->save(), new UpdateResourceFailedException());

        if ($expressModel->status === order_status_to_num('COMPLETED')) {
            event(new CompletedMissionOrder($expressModel));
        }

        return $this->response->noContent();

    }

    /**
     * 增加赏金
     *
     * @param $id
     * @return \Dingo\Api\Http\Response
     */
    public function addBounty($id)
    {
        $expressModel = $this->model->findOrFail($id);

        $expressModel->bounty = '';

        throw_unless($expressModel->save(), new UpdateResourceFailedException());

        return $this->response->noContent();
    }

    /**
     * 取消订单
     *
     * @param $id
     * @return \Dingo\Api\Http\Response
     */
    public function cancel($id)
    {
        $expressModel = $this->model->findOrFail($id);

        throw_if($expressModel->openid !== current_member_openid(), new UpdateResourceFailedException('无法取消不是你的订单!'));

        $expressModel->status = -1;

        throw_unless($expressModel->save(), new UpdateResourceFailedException());

        event(new CancelMissionOrder($expressModel));

        return $this->response->noContent();
    }

    /**
     * 接单
     *
     * @param $id
     * @return \Dingo\Api\Http\Response
     * @internal param Request $request
     */
    public function acceptOrder($id)
    {
        $expressModel = $this->model->findOrFail($id);
        $openid       = current_member_openid();

        // 不能接自己的单
        throw_if($expressModel->openid === $openid, new BadRequestHttpException('无法接单'));

        $expressModel->status     = 2;
        $expressModel->start_time = Carbon::now();
        $expressModel->accept_order_openid = $openid;

        throw_unless($expressModel->save(), new UpdateResourceFailedException('无法接单'));

        if ($expressModel->status === order_status_to_num('PROCESSING')) {
            event(new AcceptMissionOrder($expressModel));
        }

        return $this->response->noContent();
    }
}