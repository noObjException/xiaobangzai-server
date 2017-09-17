<?php

namespace App\Api\V1\Controllers;


use App\Api\BaseController;
use App\Models\ArriveTimes;
use App\Models\ExpressCompanys;
use App\Models\ExpressTypes;
use App\Models\ExpressWeights;

class GetExpressController extends BaseController
{
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