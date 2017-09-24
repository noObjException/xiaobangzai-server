<?php

namespace App\Api\V1\Transformers\Mission;

use App\Models\MissionExpress;
use League\Fractal\TransformerAbstract;

class ExpressTransformers extends TransformerAbstract
{
    public function transform(MissionExpress $lesson)
    {
        $lesson  = $lesson->toArray();
        $address = json_decode($lesson['address'], true);
        return [
            'id'             => $lesson['id'],
            'openid'         => $lesson['openid'],
            'order_num'      => $lesson['order_num'],
            'price'          => $lesson['price'],
            'total_price'    => $lesson['total_price'],
            'pay_type'       => $lesson['pay_type'],
            'remark'         => $lesson['remark'],
            'add_money'      => $lesson['add_money'],
            'college'        => $address['college'],
            'area'           => $address['area'],
            'realname'       => $address['realname'],
            'mobile'         => $address['mobile'],
            'pay_time'       => $lesson['pay_time'],
            'express_com'    => $lesson['express_com'],
            'express_type'   => $lesson['express_type'],
            'express_weight' => $lesson['express_weight'],
            'start_time'     => $lesson['start_time'],
            'finish_time'    => $lesson['finish_time'],
            'arrive_time'    => $lesson['arrive_time'],
            'created_at'     => $lesson['created_at'],
        ];
    }
}