<?php
namespace App\Api\V1\Controllers\Member;


use App\Api\BaseController;
use App\Api\V1\Transformers\Member\CreditRecordTransformers;
use App\Models\CreditRecords;
use App\Models\Members;

class CreditRecordController extends BaseController
{
    public function index(CreditRecords $model, $openid)
    {
        $data = $model->where('openid', $openid)->paginate();
        $total_credit = Members::where('openid', $openid)->first()->credit;

        return $this->response->paginator($data, new CreditRecordTransformers())->addMeta('total_credit', $total_credit);
    }
}