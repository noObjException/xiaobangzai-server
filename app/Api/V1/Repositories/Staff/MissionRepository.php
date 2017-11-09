<?php

namespace App\Api\V1\Repositories\Staff;

use App\Api\BaseRepository;
use App\Models\MissionExpress;

class MissionRepository extends BaseRepository
{
    protected $model;

    public function __construct(MissionExpress $model)
    {
        $this->model = $model;
    }

    /**
     * 获取订单列表
     *
     * @param array $params
     * @return mixed|null
     */
    public function orderLists($params)
    {
        $data = null;

        if ($params['status'] === 'waitOrder') {
            $data = $this->waitOrderLists($params);
        } else if ($params['status'] === 'processing') {
            $data = $this->processingLists($params);
        } else if ($params['status'] === 'completed') {
            $data = $this->completedLists($params);
        } else if ($params['status'] === 'canceled') {
            $data = $this->canceledLists($params);
        } else {
            $data = $this->allLists($params);
        }

        return $data;
    }

    protected function allLists($params)
    {
        return $this->model
            ->where('openid', '<>', current_member_openid())
            ->whereIn('id', [-1, 1, 2, 3])
            ->orderByDesc('id')
            ->paginate($params['per_page'] ?: 10);
    }

    /**
     * 待接单列表
     *
     * @param array $params
     * @return mixed
     */
    public function waitOrderLists($params)
    {
        return $this->model
            ->where('openid', '<>', current_member_openid())
            ->where('status', '1')
            ->whereNull('accept_order_openid')
            ->orderByDesc('id')
            ->paginate($params['per_page'] ?: 10);
    }

    /**
     * 进行中的列表
     *
     * @param array $params
     * @return mixed
     */
    protected function processingLists($params)
    {
        return $this->model
            ->where('openid', '<>', current_member_openid())
            ->where('status', '2')
            ->where('accept_order_openid', current_member_openid())
            ->orderByDesc('id')
            ->paginate($params['per_page'] ?: 10);
    }

    /**
     * 完成的任务
     *
     * @param $params
     * @return mixed
     */
    protected function completedLists($params)
    {
        return $this->model
            ->where('openid', '<>', current_member_openid())
            ->where('status', '3')
            ->where('accept_order_openid', current_member_openid())
            ->orderByDesc('id')
            ->paginate($params['per_page'] ?: 10);
    }

    /**
     * 已取消任务
     *
     * @param $params
     * @return mixed
     */
    protected function canceledLists($params)
    {
        return $this->model
            ->where('openid', '<>', current_member_openid())
            ->whereNotNull('deleted_at')
            ->where('accept_order_openid', current_member_openid())
            ->orderByDesc('id')
            ->paginate($params['per_page'] ?: 10);
    }

    public function waitOrderCount()
    {
        return $this->model
            ->where('openid', '<>', current_member_openid())
            ->where('status', '1')
            ->whereNull('accept_order_openid')
            ->count();
    }
}