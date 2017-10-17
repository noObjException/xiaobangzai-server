<?php

namespace App\Api\V1\Controllers\Staff;


use App\Api\BaseController;
use App\Api\V1\Transformers\common\SchoolTransformers;
use App\Api\V1\Transformers\Staff\StaffTransformers;
use App\Models\Schools;
use Dingo\Api\Http\Request;

class StaffController extends BaseController
{
    public function index(Schools $model)
    {
        $data = $model->where('status', '1')->get();

        return $this->response->collection($data, new SchoolTransformers());
    }

    public function store(Request $request)
    {

    }

    public function show($id)
    {
        $user = current_member_info();

        $order_counts = [
            'processing' => $user->accept_orders()->where('status', '2')->count(),
            'completed'  => $user->accept_orders()->where('status', '3')->count(),
            'canceled'   => $user->accept_orders()->where('status', '-1')->count(),
        ];

        return $this->response->item($user, new StaffTransformers())
            ->addMeta('order_counts', $order_counts);
    }
}