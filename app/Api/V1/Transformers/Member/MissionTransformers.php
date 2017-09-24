<?php

namespace App\Api\V1\Transformers\Member;

use App\Models\MissionExpress;
use League\Fractal\TransformerAbstract;

class MissionTransformers extends TransformerAbstract
{
    public function transform(MissionExpress $lesson)
    {
        $lesson  = $lesson->toArray();
        $address = json_decode($lesson['address'], true);
        return [
            'id'           => $lesson['id'],
            'status'           => $this->getStatusText($lesson['status']),
            'realname'     => $address['realname'],
            'mobile'       => $address['mobile'],
            'college'      => $address['college'],
            'area'         => $address['area'],
            'detail'       => $address['detail'],
            'order_num'    => $lesson['order_num'],
            'express_type' => $lesson['express_type'],
            'express_com'  => $lesson['express_com'],
            'total_price'  => $lesson['total_price'],
            'created_at'    => $lesson['created_at'],
        ];
    }

    protected function getStatusText($value)
    {
        $data = [
            '-1' => '已失效',
            '0'  => '待支付',
            '1'  => '待接单',
            '2'  => '配送中',
            '3'  => '已完成',
        ];

        return $data[$value];
    }
}