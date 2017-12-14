<?php

namespace App\Api\V1\Transformers\Member;

use App\Models\MemberAddress;
use League\Fractal\TransformerAbstract;

class AddressTransformers extends TransformerAbstract
{
    public function transform(MemberAddress $lesson)
    {
        return [
            'id'         => $lesson['id'],
            'realname'   => $lesson['realname'],
            'mobile'     => $lesson['mobile'],
            'college'    => $lesson->college->title,
            'area'       => $lesson->area->title,
            'detail'     => $lesson['detail'] ?? '',
            'is_default' => (Boolean)$lesson['is_default'],
            'address'    => [(string)$lesson['college_id'], (string)$lesson['area_id']]
        ];
    }
}