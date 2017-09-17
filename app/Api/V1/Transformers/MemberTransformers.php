<?php

namespace App\Api\V1\Transformers;

use App\Models\Members;
use League\Fractal\TransformerAbstract;

class MemberTransformers extends TransformerAbstract
{
    public function transform(Members $members)
    {
        return [
            'id'       => $members['id'],
            'openid'   => $members['openid'],
            'avatar'   => $members['avatar'],
            'nickname' => $members['nickname'],
            'realname' => $members['realname'],
            'balance'  => $members['balance'],
            'credit'   => $members['credit'],
        ];
    }
}