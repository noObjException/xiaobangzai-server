<?php
namespace App\Api\V1\Controllers\Member;


use App\Api\BaseController;
use App\Api\V1\Transformers\Member\MemberTransformers;

class MemberController extends BaseController
{
    public function show()
    {
        $data = current_member_info();

        $settings = get_setting('MEMBER_SETTING');

        return $this->response->item($data, new MemberTransformers())->addMeta('settings', $settings);
    }
}