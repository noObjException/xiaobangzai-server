<?php

namespace App\Api\V1\Controllers\Mission;


use App\Api\BaseController;
use App\Models\ArriveTimes;
use App\Models\CreditRecords;
use App\Models\ExpressCompanys;
use App\Models\ExpressTypes;
use App\Models\ExpressWeights;
use App\Models\Members;
use App\Models\MissionExpress;
use Dingo\Api\Exception\UpdateResourceFailedException;
use Dingo\Api\Http\Request;

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
     *  获取快递订单生成页配置信息(下拉框的选项等)
     *
     * @param ExpressCompanys $expressCompanyModel
     * @param ArriveTimes $arriveTimeModel
     * @param ExpressTypes $expressTypeModel
     * @param ExpressWeights $expressWeightModel
     * @return
     */
    public function index(ExpressCompanys $expressCompanyModel, ArriveTimes $arriveTimeModel, ExpressTypes $expressTypeModel, ExpressWeights $expressWeightModel)
    {
        $expressCompanys = $expressCompanyModel->where(['status' => '1'])->orderBy('sort', 'desc')->orderBy('id', 'desc')->pluck('title');
        $arriveTimes     = $arriveTimeModel->where(['status' => '1'])->orderBy('sort', 'desc')->orderBy('id', 'desc')->pluck('title');
        $expressTypes    = $expressTypeModel->where(['status' => '1'])->orderBy('sort', 'desc')->orderBy('id', 'desc')->pluck('title');
        $expressWeights  = $expressWeightModel->where(['status' => '1'])->orderBy('sort', 'desc')->orderBy('id', 'desc')->pluck('title');

        $data = [
            'expressCompanys' => $expressCompanys,
            'arriveTimes'     => $arriveTimes,
            'expressTypes'    => $expressTypes,
            'expressWeights'  => $expressWeights
        ];

        return $this->response->array(compact('data'));
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
            $balance = $expressModel->member->balance;
            if ($balance < $expressModel->total_price) {
                throw new UpdateResourceFailedException('您的余额不足!');
            }
        }

        $expressModel->pay_type = $pay_type;
        $expressModel->pay_time = date('Y-m-d H:i:s');
        $expressModel->status   = 1;

        if ($expressModel->save()) {
            return $this->response->noContent();
        } else {
            throw new UpdateResourceFailedException();
        }
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
        $settings     = get_setting('GET_EXPRESS_SETTING');

        $expressModel->finish_time = date('Y-m-d H:i:s');
        $expressModel->status      = 3;

        if ($expressModel->save()) {
            $creditRecord = new CreditRecords();
            $creditRecord->openid   = $expressModel->openid;
            $creditRecord->nickname = $expressModel->member->nickname;
            $creditRecord->action   = '完成任务返积分';
            $creditRecord->value    = $settings['credit'];
            $creditRecord->save();

            $member = Members::where('openid', $expressModel->openid)->first();
            $member->credit += $settings['credit'];
            $member->save();

            return $this->response->noContent();
        } else {
            throw new UpdateResourceFailedException();
        }
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

        if ($expressModel->save()) {
            return $this->response->noContent();
        } else {
            throw new UpdateResourceFailedException();
        }
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

        if ($expressModel->save()) {
            return $this->response->noContent();
        } else {
            throw new UpdateResourceFailedException();
        }
    }

    /**
     * 接单
     *
     * @param $id
     * @return \Dingo\Api\Http\Response
     */
    public function acceptOrder($id)
    {
        $expressModel = $this->model->findOrFail($id);

        $expressModel->status = 2;
        $expressModel->start_time = time();

        if($expressModel->save()) {
            return $this->response->noContent();
        } else {
            throw new UpdateResourceFailedException('无法接单');
        }
    }
}