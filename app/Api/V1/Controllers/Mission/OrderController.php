<?php
namespace App\Api\V1\Controllers\Mission;


use App\Api\BaseController;
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
     *  支付订单
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

        $expressModel->pay_type = $pay_type;
        $expressModel->pay_time = date('Y-m-d H:i:s');
        $expressModel->status = 1;

        if($expressModel->save()) {
            return $this->response->noContent();
        }else{
            throw new UpdateResourceFailedException();
        }
    }

    /**
     *  完成订单
     *
     * @param $id
     * @return \Dingo\Api\Http\Response
     * @internal param MissionExpress $this ->model
     */
    public function completed($id)
    {
        $expressModel = $this->model->findOrFail($id);

        $expressModel->finish_time = date('Y-m-d H:i:s');
        $expressModel->status = 3;

        if($expressModel->save()) {
            return $this->response->noContent();
        }else{
            throw new UpdateResourceFailedException();
        }
    }

    public function addBounty($id)
    {
        $expressModel = $this->model->findOrFail($id);

        $expressModel->bounty = '';

        if($expressModel->save()) {
            return $this->response->noContent();
        }else{
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

        if($expressModel->save()) {
            return $this->response->noContent();
        }else{
            throw new UpdateResourceFailedException();
        }
    }
}