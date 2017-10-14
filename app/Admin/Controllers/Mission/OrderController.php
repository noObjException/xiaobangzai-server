<?php
namespace App\Admin\Controllers\Mission;


use App\Http\Controllers\Controller;
use App\Models\MissionExpress;

class OrderController extends Controller
{
    /**
     * 后台支付订单
     *
     * @param MissionExpress $model
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function pay(MissionExpress $model, $id)
    {
        $expressModel = $model->findOrFail($id);

        if ($expressModel->status !== 0) {
            return response()->json([
                'status'  => false,
                'message' => '无法支付!',
            ]);
        }

        $expressModel->status   = 1;
        $expressModel->pay_type = 'ADMIN_PAY';
        $expressModel->pay_time = date('Y-m-d H:i:s');

        if ($expressModel->save()) {
            $status  = true;
            $message = '付款成功!';
        } else {
            $status  = false;
            $message = '付款失败!';
        }

        return response()->json([
            'status'  => $status,
            'message' => $message,
        ]);
    }

    public function assignOrder(MissionExpress $model,$id)
    {
        $openid = request('openid');

        $expressModel = $model->findOrFail($id);

        if (!empty($expressModel->accept_order_openid)) {
            return response()->json([
                'status'  => false,
                'message' => '该订单已有人进行配送!',
            ]);
        }

        if ($expressModel->openid === $openid) {
            return response()->json([
                'status'  => false,
                'message' => '发单人和配送员相同, 不能分配!',
            ]);
        }

        $expressModel->status = 2;
        $expressModel->start_time = date('Y-m-d H:i:s');
        $expressModel->accept_order_openid = $openid;

        if ($expressModel->save()) {
            $status  = true;
            $message = '分配成功!';
        } else {
            $status  = false;
            $message = '分配失败!';
        }

        return response()->json([
            'status'  => $status,
            'message' => $message,
        ]);
    }
}