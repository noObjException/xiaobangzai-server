<?php

namespace App\Api;

use Illuminate\Http\Request;

class WechatController extends BaseController
{
    use WechatHelpers;

    protected $wechat;

    public function __construct()
    {
        $this->wechat = $this->getWechat();
    }

    /**
     *  微信处理入口
     */
    public function serve()
    {
        $server = $this->getServer();

        $server->setMessageHandler(function ($message) {
            return "您好！欢迎关注我!";
        });

        $response = $server->serve();

        return $response;
    }

    public function getOpenid(Request $request)
    {
        return ['data' => ['hello']];
    }

    public function authMember(Request $request)
    {
        return '';
    }
}