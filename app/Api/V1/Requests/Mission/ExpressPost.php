<?php

namespace App\Api\V1\Requests\Mission;


use App\Api\BaseRequest;

class ExpressPost extends BaseRequest
{
    public function rules()
    {
        return [
            'express_com'    => 'required',
            'express_type'   => 'required',
            'express_option' => 'required',
            'arrive_time'    => 'required',
            'address'        => 'required',
        ];
    }

    public function messages()
    {
        return [
            'express_com.required'    => '快递公司不能为空!',
            'express_type.required'   => '物品类型不能为空!',
            'express_option.required' => '物品规格不能为空!',
            'arrive_time.required'    => '送达时间不能为空!',
            'address.required'        => '请选择收获地址!',
        ];
    }
}