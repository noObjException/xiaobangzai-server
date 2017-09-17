<?php

namespace App\Api\V1\Controllers;


use App\Api\BaseController;
use App\Api\V1\Transformers\ChooseAreaTransformers;
use App\Api\V1\Transformers\MemberAddressTransformers;
use App\Models\MemberAddress;
use App\Models\SchoolAreas;
use Illuminate\Http\Request;

class MemberAddressController extends BaseController
{
    /**
     *  常用地址列表
     *
     * @return \Dingo\Api\Http\Response
     */
    public function index(Request $request)
    {
        $openid = $request->get('openid');

        $data = MemberAddress::where(['openid' => $openid])->get();

        return $this->response->collection($data, new MemberAddressTransformers());
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


    public function store(Request $request)
    {
        $params = $request->json()->all();

        $address = explode(' ', $params['address']);
        $params['college'] = $address[0];
        $params['area']    = $address[1];
        unset($params['address']);

        MemberAddress::create($params);

        return $this->response->created();
    }
}