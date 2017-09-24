<?php

namespace App\Api\V1\Controllers\Member;

use App\Api\BaseController;
use App\Api\V1\Transformers\Member\MissionTransformers;
use App\Models\MissionExpress;
use Dingo\Api\Http\Request;

class MissionController extends BaseController
{
    public function index(Request $request, MissionExpress $model, $openid, $status = 'all')
    {
        $condition = [
            ['openid', $openid]
        ];

        if ($status !== 'all') {
            $condition[] = ['status', $this->getStatusValue($status)];
        }

        $data = $model->where($condition)->paginate(104);

        return $this->response->paginator($data, new MissionTransformers());
    }

    protected function getStatusValue($text): int
    {
        $data = [
            'waitPay'    => 0,
            'waitOrder'  => 1,
            'processing' => 2,
            'completed'  => 3,
        ];
        return $data[$text];
    }
}