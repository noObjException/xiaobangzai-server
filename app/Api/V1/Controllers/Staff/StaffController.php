<?php

namespace App\Api\V1\Controllers\Staff;


use App\Api\BaseController;
use App\Api\V1\Transformers\common\SchoolTransformers;
use App\Api\V1\Transformers\Staff\StaffTransformers;
use App\Models\MissionExpress;
use App\Models\Schools;

class StaffController extends BaseController
{
    public function index(Schools $model)
    {
        $data = $model->where('status', '1')->get();

        return $this->response->collection($data, new SchoolTransformers());
    }

    public function show($id)
    {
        $user = current_member_info();

        $order_counts = [
            'waitOrder'  => MissionExpress::where('status', '1')->whereNull('accept_order_openid')->where('accept_order_openid', '<>', current_member_openid())->count(),
            'processing' => $user->accept_orders()->where('status', '2')->count(),
            'completed'  => $user->accept_orders()->where('status', '3')->count(),
            'canceled'   => $user->accept_orders()->where('status', '-1')->count(),
        ];

        return $this->response->item($user, new StaffTransformers())
            ->addMeta('order_counts', $order_counts);
    }
}