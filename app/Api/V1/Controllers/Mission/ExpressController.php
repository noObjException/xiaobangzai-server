<?php

namespace App\Api\V1\Controllers\Mission;


use App\Api\BaseController;
use App\Api\V1\Transformers\Mission\ExpressTransformers;
use App\Models\ArriveTimes;
use App\Models\ExpressCompanys;
use App\Models\ExpressTypes;
use App\Models\ExpressWeights;
use App\Models\MissionExpress;
use Dingo\Api\Exception\StoreResourceFailedException;
use Dingo\Api\Http\Request;
use Dingo\Api\Http\Response;

class ExpressController extends BaseController
{
    /**
     * 任务列表
     *
     * @param Request $request
     * @param MissionExpress $model
     * @return \Dingo\Api\Http\Response
     */
    public function index(Request $request, MissionExpress $model): Response
    {
        $params = $request->all();
        $status = $params['status'] ?: 'all';

        if ($status !== 'all') {
            $condition[] = ['status', $this->getStatusValue($status)];
        }
        $condition[] = ['openid', $params['openid']];

        $data = $model->where($condition)->orderBy('id', 'desc')->paginate($params['per_page'] ?: 10);

        return $this->response->paginator($data, new ExpressTransformers());
    }

    /**
     * 获取任务详情
     *
     * @param MissionExpress $model
     * @param $id
     * @return Response
     */
    public function show(MissionExpress $model, $id): Response
    {
        $data = $model->findOrFail($id);

        return $this->response->item($data, new ExpressTransformers());
    }

    /**
     *  生成取快递任务
     *
     * @param Request $request
     *
     * @param MissionExpress $model
     * @return Response
     */
    public function store(Request $request, MissionExpress $model)
    {
        $params = $request->json()->all();

        $params['address']     = json_encode($params['address']);
        $params['price']       = 2;
        $params['total_price'] = $params['price'] + $params['add_money'];
        $params['order_num']   = '454dingdanhao';
        $params['status']      = 0;

        $id = $model->create($params)->id;
        $data = ['id' => $id];

        if(empty($id)) {
            throw new StoreResourceFailedException();
        }

        return $this->response->array(compact('data'));
    }

    /**
     *  取快递订单生成页配置信息(下拉框的选项等)
     *
     * @param ExpressCompanys $expressCompanys
     * @param ArriveTimes $arriveTimes
     * @return mixed
     */
    public function getInitData(ExpressCompanys $expressCompanys, ArriveTimes $arriveTimes)
    {
        $expressCompanys = $expressCompanys->where(['status' => '1'])->orderBy('sort', 'desc')->orderBy('id', 'desc')->pluck('title');
        $arriveTimes     = $arriveTimes->where(['status' => '1'])->orderBy('sort', 'desc')->orderBy('id', 'desc')->pluck('title');

        $data = [
            'expressCompanys' => $expressCompanys,
            'arriveTimes'     => $arriveTimes
        ];

        return $this->response->array(compact('data'));
    }

    /**
     *  快递物品信息的选项
     *
     * @param ExpressTypes $expressTypes
     * @param ExpressWeights $expressWeights
     * @return mixed
     */
    public function getInitInfoData(ExpressTypes $expressTypes, ExpressWeights $expressWeights)
    {
        $expressTypes   = $expressTypes->where(['status' => '1'])->orderBy('sort', 'desc')->orderBy('id', 'desc')->get();
        $expressWeights = $expressWeights->where(['status' => '1'])->orderBy('sort', 'desc')->orderBy('id', 'desc')->pluck('title');

        $data = [
            'expressTypes'   => $expressTypes,
            'expressWeights' => $expressWeights
        ];

        return $this->response->array(compact('data'));
    }

    /**
     * 获取任务状态值
     *
     * @param $text
     * @return int
     */
    protected function getStatusValue($text): int
    {
        $data = [
            'waitPay'    => 0,
            'waitOrder'  => 1,
            'processing' => 2,
            'completed'  => 3,
        ];
        return $data[$text];
    }
}