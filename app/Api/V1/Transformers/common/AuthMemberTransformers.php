<?php

namespace App\Api\V1\Transformers\common;

use App\Models\Members;
use League\Fractal\TransformerAbstract;


class AuthMemberTransformers extends TransformerAbstract
{
    public function transform(Members $lesson)
    {
        return [
            'openid'      => $lesson['openid'],
            'realname'    => $lesson['realname'],
            'nickname'    => $lesson['nickname'],
            'is_identify' => (boolean)$lesson['is_identify'],
        ];
    }
}