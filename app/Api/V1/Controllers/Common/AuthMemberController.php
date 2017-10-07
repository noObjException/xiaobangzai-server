<?php
namespace App\Api\V1\Controllers\Common;


use App\Api\BaseController;
use App\Api\V1\Transformers\common\AuthMemberTransformers;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthMemberController extends BaseController
{
    public function authMember()
    {
        $data = JWTAuth::parseToken()->authenticate();

        return $this->response->item($data, new AuthMemberTransformers());
    }
}