<?php

namespace App\Api\V1\Controllers\Member;


use App\Api\BaseController;
use App\Api\V1\Transformers\ChooseAreaTransformers;
use App\Api\V1\Transformers\Member\AddressTransformers;
use App\Models\MemberAddress;
use App\Models\SchoolAreas;
use Illuminate\Http\Request;

class AddressController extends BaseController
{
    /**
     *  常用地址列表
     *
     * @param Request $request
     * @return \Dingo\Api\Http\Response
     */
    public function index(Request $request)
    {
        $openid = $request->get('openid');

        $data = MemberAddress::where(['openid' => $openid])->get();

        return $this->response->collection($data, new AddressTransformers());
    }


    /**
     *  获取可选择的学校区域
     *
     * @return \Dingo\Api\Http\Response
     */
    public function chooseAreas()
    {
        $data = SchoolAreas::where(['status' => '1'])->get();

        return $this->response->collection($data, new ChooseAreaTransformers());
    }

    /**
     *  生成会员收货地址
     *
     * @param Request $request
     * @param MemberAddress $model
     * @return \Dingo\Api\Http\Response
     */
    public function store(Request $request, MemberAddress $model)
    {
        $params = $request->json()->all();

        $address           = explode(' ', $params['address']);
        $params['college'] = $address[0];
        $params['area']    = $address[1];
        unset($params['address']);

        if ($params['is_default']) {
            $model->where('openid', $params['openid'])->update(['is_default' => '0']);
        }

        $model->create($params);

        return $this->response->created();
    }
}