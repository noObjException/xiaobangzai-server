<?php

namespace App\Api\V1\Controllers\Mission;


use App\Api\BaseController;
use App\Api\V1\Requests\Mission\ExpressPost;
use App\Api\V1\Repositories\Mission\ExpressRepository;
use App\Api\V1\Transformers\Mission\ExpressTransformers;
use App\Events\CreateMissionOrder;
use App\Models\ExpressOptions;
use App\Models\MissionExpress;
use Dingo\Api\Exception\StoreResourceFailedException;
use Dingo\Api\Http\Request;
use Dingo\Api\Http\Response;

class ExpressController extends BaseController
{
    protected $repository;

    public function __construct(ExpressRepository $repository)
    {
        $this->repository = $repository;
    }

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
        $data = $this->repository->getCreatePageData();

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
     * @param ExpressPost $request
     * @param MissionExpress $model
     * @return Response
     */
    public function store(ExpressPost $request, MissionExpress $model): Response
    {
        $params   = $request->json()->all();
        $settings = get_setting('GET_EXPRESS_SETTING');

        $params['openid']    = current_member_openid();
        $params['user_id']   = current_user_id();
        $params['address']   = json_encode($params['address']);
        $params['price']     = $settings['price'];
        $params['order_num'] = get_order_num('EX');
        $params['status']    = 0;

        // 规格价
        $params['option_price'] = ExpressOptions::findOrFail($params['option_id'])->price;
        unset($params['option_id']);

        $params['total_price'] = $params['price'] + $params['bounty'] + $params['option_price'];

        // 计算额外费用
        $extra_costs = [];

        // 上楼加价
        if (in_array('upstairs_price', $params['extra_costs']) && $settings['switch_upstairs_price']) {
            $params['total_price']         += $settings['upstairs_price'];
            $extra_costs['upstairs_price'] = $settings['upstairs_price'];
        }

        $params['extra_costs'] = json_encode($extra_costs);

        throw_unless($expressModel = $model->create($params), new StoreResourceFailedException('下单失败, 请稍候重试'));

        $data = ['id' => $expressModel->id];

        if ($expressModel->status === order_status_to_num('WAIT_PAY')) {
            event(new CreateMissionOrder($expressModel));
        }

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