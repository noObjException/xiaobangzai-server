<?php
namespace App\Api\V1\Controllers\Staff;


use App\Api\BaseController;
use App\Api\V1\Transformers\Mission\ExpressTransformers;
use App\Models\MissionExpress;

class MissionController extends BaseController
{
    /**
     * 获取可接单列表
     *
     * @param MissionExpress $model
     * @return \Dingo\Api\Http\Response
     */
    public function index(MissionExpress $model)
    {
        $data = $model->where('status', '1')->orderBy('id', 'desc')->paginate(10);

        return $this->response->paginator($data, new ExpressTransformers());
    }

}