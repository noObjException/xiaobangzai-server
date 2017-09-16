<?php

namespace App\Http\Controllers;

class WechatController extends Controller
{
    use WechatHelpers;
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
}