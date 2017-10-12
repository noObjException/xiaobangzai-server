<?php

namespace App\Api\V1\Controllers\Member;


use App\Api\BaseController;
use App\Api\V1\Transformers\ChooseAreaTransformers;
use App\Api\V1\Transformers\Member\AddressTransformers;
use App\Models\MemberAddress;
use App\Models\SchoolAreas;
use Dingo\Api\Exception\StoreResourceFailedException;
use Dingo\Api\Http\Response;
use Illuminate\Http\Request;

class AddressController extends BaseController
{
    /**
     *  常用地址列表
     *
     * @param MemberAddress $model
     * @return Response
     */
    public function index(MemberAddress $model): Response
    {
        $data = $model->where(['openid' => current_member_openid()])->get();

        return $this->response->collection($data, new AddressTransformers());
    }


    /**
     *  获取可选择的学校区域
     *
     * @param SchoolAreas $model
     * @return Response
     */
    public function chooseAreas(SchoolAreas $model): Response
    {
        $data = $model->where(['status' => '1'])->get();

        return $this->response->collection($data, new ChooseAreaTransformers());
    }

    /**
     *  生成会员收货地址
     *
     * @param Request $request
     * @param MemberAddress $model
     * @return \Dingo\Api\Http\Response
     */
    public function store(Request $request, MemberAddress $model): Response
    {
        $params = $request->json()->all();
        $openid = current_member_openid();

        $address           = explode(' ', $params['address']);
        $params['college'] = $address[0];
        $params['area']    = $address[1];
        unset($params['address']);
        $params['openid']  = $openid;

        if ($params['is_default']) {
            $model->where('openid', $openid)->update(['is_default' => '0']);
        }

        throw_unless($model->create($params), new StoreResourceFailedException());

        return $this->response->created();
    }
}