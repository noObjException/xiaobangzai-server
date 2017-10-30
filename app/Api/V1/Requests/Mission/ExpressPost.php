<?php

namespace App\Api\V1\Requests\Mission;


use Dingo\Api\Http\FormRequest;

class ExpressPost extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'express_com'    => 'required',
            'express_type'   => 'required',
            'express_weight' => 'required',
            'arrive_time'    => 'required',
            'address'        => 'required',
        ];
    }

    public function messages()
    {
        return [
            'express_com.required'    => '快递公司不能为空!',
            'express_type.required'   => '物品类型不能为空!',
            'express_weight.required' => '物品重量不能为空!',
            'arrive_time.required'    => '送达时间不能为空!',
            'address.required'        => '请选择收获地址!',
        ];
    }
}