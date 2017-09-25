<?php

namespace App\Api\V1\Controllers\Member;

use App\Api\BaseController;
use App\Api\V1\Transformers\Member\MissionTransformers;
use App\Models\MissionExpress;
use Dingo\Api\Http\Request;

class MissionController extends BaseController
{
    /**
     * 任务列表
     *
     * @param Request $request
     * @param MissionExpress $model
     * @return \Dingo\Api\Http\Response
     */
    public function index(Request $request, MissionExpress $model)
    {
        $params = $request->all();
        $status = $params['status'] ?: 'all';

        if ($status !== 'all') {
            $condition[] = ['status', $this->getStatusValue($status)];
        }
        $condition[] = ['openid', $params['openid']];

        $data = $model->where($condition)->paginate(15);

        return $this->response->paginator($data, new MissionTransformers());
    }

    /**
     * 任务详情
     *
     * @param MissionExpress $model
     * @param $id
     * @return \Dingo\Api\Http\Response
     */
    public function show(MissionExpress $model, $id)
    {
        $data = $model->findOrFail($id);

        return $this->response->item($data, new MissionTransformers());
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