<?php

namespace App\Api\V1\Controllers\Member;


use App\Api\BaseController;
use App\Api\V1\Transformers\Member\CreditRecordTransformers;
use App\Models\CreditRecords;
use App\Models\Members;

class CreditRecordController extends BaseController
{
    public function index(CreditRecords $model)
    {
        $data = $model->where('openid', current_member_openid())
                      ->orderBy('id', 'desc')
                      ->paginate(request('per_page', 15));

        return $this->response->paginator($data, new CreditRecordTransformers())
            ->addMeta('total_credit', current_member_info('credit'));
    }
}