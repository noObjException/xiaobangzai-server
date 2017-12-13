<?php

namespace App\Api\V1\Controllers\Member;


use App\Api\BaseController;
use App\Api\V1\Requests\Member\BalancePost;
use App\Models\Balances;
use Dingo\Api\Exception\StoreResourceFailedException;
use Dingo\Api\Http\Response;

class BalanceController extends BaseController
{
    public function store(BalancePost $request, Balances $model): Response
    {
        $params = $request->json()->all();
        $member = current_member_info();

        throw_if($member->balance < $params['cash_balance'], new StoreResourceFailedException('您的余额不足!'));

        $params['user_id']           = $member->id;
        $params['remaining_balance'] = $member->balance;
        $params['status']            = 0;

        throw_unless($model->create($params), new StoreResourceFailedException('申请失败, 请稍候重试!'));

        return $this->response->created();
    }
}