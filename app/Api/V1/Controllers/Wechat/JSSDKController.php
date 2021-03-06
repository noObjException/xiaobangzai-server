<?php

namespace App\Api\V1\Controllers\Wechat;

use App\Api\BaseController;
use App\Services\Wechat;

class JSSDKController extends BaseController
{
    /**
     * 获取jsSDK配置
     *
     * @return mixed
     */
    public function getConfig()
    {
        $request_url = request('request_url');

        $jssdk = Wechat::app()->jssdk;

        $jssdk->setUrl($request_url);

        $api_lists = [
            'chooseImage',
            'previewImage',
            'uploadImage',
            'getLocalImgData',
            'chooseWXPay',
        ];

        $data = $jssdk->buildConfig($api_lists, env('JSSDK_DEBUG'), false, false);

        return $this->response->array(compact('data'));
    }
}