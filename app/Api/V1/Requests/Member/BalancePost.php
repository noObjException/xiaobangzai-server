<?php

namespace App\Api\V1\Requests\Member;


use App\Api\BaseRequest;

class BalancePost extends BaseRequest
{
    public function rules()
    {
        return [
            'cash_balance' => 'required|numeric',
        ];
    }

    public function messages()
    {
        return [
            'cash_balance.required' => '金额不能为空!',
            'cash_balance.numeric'  => '提现金额必须是合法数值',
        ];
    }
}