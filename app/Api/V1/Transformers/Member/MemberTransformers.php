<?php

namespace App\Api\V1\Transformers\Member;

use App\Models\Members;
use League\Fractal\TransformerAbstract;

class MemberTransformers extends TransformerAbstract
{
    public function transform(Members $members)
    {
        return [
            'id'          => $members['id'],
            'openid'      => $members['openid'],
            'avatar'      => $members['avatar'],
            'nickname'    => $members['nickname'],
            'realname'    => $members['realname'],
            'balance'     => $members['balance'],
            'point'      => $members['point'],
            'is_identify' => $members['is_identify'],
            'is_staff'    => $members['is_staff'],
        ];
    }
}