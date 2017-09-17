<?php
namespace App\Api\V1\Controllers;


use App\Api\BaseController;
use App\Api\V1\Transformers\MemberTransformers;
use App\Models\Members;

class MemberController extends BaseController
{
    public function show($openid)
    {
        $data = Members::where(['openid' => $openid])->first();

        return $this->response->item($data, new MemberTransformers());
    }
}