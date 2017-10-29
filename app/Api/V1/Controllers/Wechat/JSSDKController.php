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

        $js = Wechat::app()->js;

        $js->setUrl($request_url);

        $api_lists = [
            'chooseImage',
            'previewImage',
            'uploadImage',
            'getLocalImgData',
            'chooseWXPay',
        ];

        $data = $js->config($api_lists, true, false, false);

        return $this->response->array(compact('data'));
    }
}