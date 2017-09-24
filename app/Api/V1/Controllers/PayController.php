<?php
namespace App\Api\V1\Controllers;


use App\Api\BaseController;
use App\Models\MissionExpress;
use Dingo\Api\Exception\UpdateResourceFailedException;
use Dingo\Api\Http\Request;

class PayController extends BaseController
{
    /**
     *  支付订单
     *
     * @param Request $request
     * @param $id
     * @return \Dingo\Api\Http\Response
     */
    public function update(Request $request, $id)
    {
        $pay_type = $request->get('pay_type');

        $expressModel = MissionExpress::findOrFail($id);

        $expressModel->pay_type = $pay_type;
        $expressModel->pay_time = date('Y-m-d H:i:s');
        $expressModel->status = 1;

        if($expressModel->save()) {
            return $this->response->noContent();
        }else{
            throw new UpdateResourceFailedException();
        }
    }
}