<?php

namespace App\Api\V1\Controllers\Mission;


use App\Api\BaseController;
use App\Models\ArriveTimes;
use App\Models\ExpressCompanys;
use App\Models\ExpressTypes;
use App\Models\ExpressWeights;
use App\Models\MissionExpress;
use Dingo\Api\Http\Request;

class ExpressController extends BaseController
{
    /**
     *  生成取快递任务
     *
     * @param Request $request
     *
     * @return \Dingo\Api\Http\Response
     */
    public function store(Request $request)
    {
        $params = $request->json()->all();

        $params['address']     = json_encode($params['address']);
        $params['price']       = 2;
        $params['total_price'] = $params['price'] + $params['add_money'];
        $params['order_num']   = '454dingdanhao';
        $params['status']      = 0;
        $params['pay_type']    = 0;

        MissionExpress::create($params);

        return $this->response->created();
    }

    /**
     *  取快递订单生成页配置信息(下拉框的选项等)
     *
     * @return mixed
     */
    public function getInitData()
    {
        $expressCompanys = ExpressCompanys::where(['status' => '1'])->orderBy('sort', 'desc')->orderBy('id', 'desc')->pluck('title');
        $arriveTimes     = ArriveTimes::where(['status' => '1'])->orderBy('sort', 'desc')->orderBy('id', 'desc')->pluck('title');

        $data = [
            'expressCompanys' => $expressCompanys,
            'arriveTimes'     => $arriveTimes
        ];

        return $this->response->array(compact('data'));
    }

    /**
     *  快递物品信息的选项
     *
     * @return mixed
     */
    public function getInitInfoData()
    {
        $expressTypes   = ExpressTypes::where(['status' => '1'])->orderBy('sort', 'desc')->orderBy('id', 'desc')->get();
        $expressWeights = ExpressWeights::where(['status' => '1'])->orderBy('sort', 'desc')->orderBy('id', 'desc')->pluck('title');

        $data = [
            'expressTypes'   => $expressTypes,
            'expressWeights' => $expressWeights
        ];

        return $this->response->array(compact('data'));
    }
}