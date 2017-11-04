<?php

namespace App\Api\V1\Controllers\Member;


use App\Api\BaseController;
use App\Api\V1\Transformers\Member\PointRecordTransformers;
use App\Models\PointRecords;

class PointRecordController extends BaseController
{
    public function index(PointRecords $model)
    {
        $data = $model->where('openid', current_member_openid())
                      ->orderBy('id', 'desc')
                      ->paginate(request('per_page', 15));

        return $this->response->paginator($data, new PointRecordTransformers())
            ->addMeta('total_point', current_member_info('point'));
    }
}