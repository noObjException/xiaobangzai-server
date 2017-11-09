<?php

namespace App\Api\V1\Controllers\Staff;


use App\Api\BaseController;
use App\Api\V1\Repositories\Staff\MissionRepository;
use App\Api\V1\Transformers\Mission\ExpressTransformers;
use Dingo\Api\Http\Response;
use Illuminate\Http\Request;

class MissionController extends BaseController
{
    protected $repository;

    public function __construct(MissionRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * 获取服务端相关订单列表列表
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request): Response
    {
        $params = $request->all();

        $data = $this->repository->orderLists($params);

        return $this->response->paginator($data, new ExpressTransformers())
                                ->addMeta('member', current_member_info());
    }
}