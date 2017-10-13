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
        $condition[] = ['openid', current_member_openid()];

        $data = $model->where($condition)->orderBy('id', 'desc')->paginate($params['per_page'] ?: 10);

        return $this->response->paginator($data, new ExpressTransformers());
    }

    /**
     *  生成任务页
     */
    public function create()
    {
        $expressCompanys = ExpressCompanys::where(['status' => '1'])->orderBy('sort', 'desc')->orderBy('id', 'desc')->pluck('title');
        $arriveTimes     = ArriveTimes::where(['status' => '1'])->orderBy('sort', 'desc')->orderBy('id', 'desc')->pluck('title');
        $expressTypes    = ExpressTypes::where(['status' => '1'])->orderBy('sort', 'desc')->orderBy('id', 'desc')->pluck('title');
        $expressWeights  = ExpressWeights::where(['status' => '1'])->orderBy('sort', 'desc')->orderBy('id', 'desc')->pluck('title');

        $data = [
            'expressCompanys' => $expressCompanys,
            'arriveTimes'     => $arriveTimes,
            'expressTypes'    => $expressTypes,
            'expressWeights'  => $expressWeights,
            'settings'        => get_setting('GET_EXPRESS_SETTING'),
        ];

        return $this->response->array(compact('data'));
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

        return $this->response->item($data, new ExpressTransformers())
                    ->addMeta('member', $data->member)
                    ->addMeta('settings', get_setting('GET_EXPRESS_SETTING'));
    }

    /**
     *  生成取快递任务
     *
     * @param Request $request
     * @param MissionExpress $model
     * @return Response
     */
    public function store(Request $request, MissionExpress $model): Response
    {
        $params   = $request->json()->all();
        $settings = get_setting('GET_EXPRESS_SETTING');

        $params['openid']    = current_member_openid();
        $params['address']   = json_encode($params['address']);
        $params['price']     = $settings['price'];
        $params['order_num'] = get_order_num('EX');
        $params['status']    = 0;

        $params['total_price'] = $params['price'] + $params['bounty'];

        // 计算额外费用
        $extra_costs = [];
        // 上楼加价
        if (in_array('upstairs_price', $params['extra_costs'])) {
            $params['total_price']         += $settings['upstairs_price'];
            $extra_costs['upstairs_price'] = $settings['upstairs_price'];
        }
        // 计算超重费用
        $diff = (int)$params['express_weight'] - (int)$settings['base_weight'];
        if ($diff > 0) {
            $params['total_price']            += $diff * $settings['over_weight_price'];
            $extra_costs['over_weight_price'] = $diff * $settings['over_weight_price'];
        }

        $params['extra_costs'] = json_encode($extra_costs);

        $id   = $model->create($params)->id;
        $data = ['id' => $id];

        throw_if(empty($id), new StoreResourceFailedException());

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