<?php

namespace App\Api\V1\Transformers\Mission;

use App\Models\MissionExpress;
use Carbon\Carbon;
use League\Fractal\TransformerAbstract;

class ExpressTransformers extends TransformerAbstract
{
    public function transform(MissionExpress $lesson)
    {
        $address     = json_decode($lesson['address'], true);
        $extra_costs = json_decode($lesson['extra_costs'], true);

        return [
            'id'               => $lesson['id'],
            'status'           => $this->getStatusText($lesson['status']),
            'realname'         => $address['realname'],
            'mobile'           => $address['mobile'],
            'college'          => $address['college'],
            'area'             => $address['area'],
            'detail'           => $address['detail'],
            'order_num'        => $lesson['order_num'],
            'express_type'     => $lesson['express_type'],
            'express_com'      => $lesson['express_com'],
            'express_option'   => $lesson['express_option'],
            'option_price'     => $lesson['option_price'],
            'arrive_time'      => $lesson['arrive_time'],
            'bounty'           => $lesson['bounty'],
            'price'            => $lesson['price'],
            'total_price'      => $lesson['total_price'],
            'created_at'       => $lesson['created_at']->toDateTimeString(),
            'remark'           => $lesson['remark'],
            'avatar'           => $lesson->member->avatar ?: '',
            'to_staff_money'   => $lesson['to_staff_money'],
            'pay_time'         => $lesson['pay_time'],
            'start_time'       => $lesson['start_time'],
            'finish_time'      => $lesson['finish_time'],
            'pickup_code'      => $lesson['pickup_code'],
            'upstairs_price'   => number_format(!empty($extra_costs['upstairs_price']) ? $extra_costs['upstairs_price'] : 0, 2),
            'overweight_price' => number_format(!empty($extra_costs['overweight_price']) ? $extra_costs['overweight_price'] : 0, 2),
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