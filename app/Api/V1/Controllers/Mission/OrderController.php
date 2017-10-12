<?php

namespace App\Api\V1\Controllers\Mission;


use App\Api\BaseController;
use App\Events\ChangedCredit;
use App\Models\ArriveTimes;
use App\Models\CreditRecords;
use App\Models\ExpressCompanys;
use App\Models\ExpressTypes;
use App\Models\ExpressWeights;
use App\Models\Members;
use App\Models\MissionExpress;
use Dingo\Api\Exception\UpdateResourceFailedException;
use Dingo\Api\Http\Request;
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
     * @param $id
     * @return \Dingo\Api\Http\Response
     * @internal param MissionExpress $this ->model
     */
    public function pay(Request $request, $id)
    {
        $pay_type = $request->get('pay_type');

        $expressModel = $this->model->findOrFail($id);

        if ($pay_type === 'BALANCE_PAY') {
            throw_if($expressModel->member->balance < $expressModel->total_price, new UpdateResourceFailedException('您的余额不足!'));
        }

        $expressModel->pay_type = $pay_type;
        $expressModel->pay_time = date('Y-m-d H:i:s');
        $expressModel->status   = 1;

        throw_unless($expressModel->save(), new UpdateResourceFailedException());

        return $this->response->noContent();
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

        $settings = get_setting('GET_EXPRESS_SETTING');

        $expressModel->finish_time = date('Y-m-d H:i:s');
        $expressModel->status      = 3;

        throw_unless($expressModel->save(), new UpdateResourceFailedException());

        $member = Members::where('openid', $expressModel->openid)->first();
        event(new ChangedCredit($member, '完成任务增加积分', $settings['credit']));

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

        $expressModel->status = -1;

        throw_unless($expressModel->save(), new UpdateResourceFailedException());

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
        $expressModel->start_time = date('Y-m-d H:i:s');;
        $expressModel->accept_order_openid = $openid;

        throw_unless($expressModel->save(), new UpdateResourceFailedException('无法接单'));

        return $this->response->noContent();
    }
}