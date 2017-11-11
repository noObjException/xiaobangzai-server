<?php
namespace App\Api\V1\Controllers\Common;


use App\Api\BaseController;
use App\Api\V1\Transformers\common\AuthMemberTransformers;

class AuthMemberController extends BaseController
{
    public function authMember()
    {
        $data = current_member_info();

        return $this->response->item($data, new AuthMemberTransformers())
                                ->addMeta('member_settings', get_setting('MEMBER_SETTING'));
    }
}