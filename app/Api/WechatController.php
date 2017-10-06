<?php

namespace App\Api;

use App\Models\Members;
use EasyWeChat\Support\Log;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class WechatController extends BaseController
{
    protected $wechat;

    public function __construct(WechatHelpers $wechat)
    {
        $this->wechat = $wechat;
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

    /**
     * 1.通过中间件获取授权信息,保存在session中
     * 2.以openid生成api验证用token
     * 3.重定向回前端验证页,并通过cookie携带token
     *
     * @return array
     * @internal param Request $request
     */
    public function getOpenid()
    {
        $openid = session('wechat.oauth_user');
        Log::info('openid---'.$openid);
        $user = Members::where('openid', $openid)->first();

        $token = JWTAuth::fromUser($user);

        return redirect(env('CLIENT_URL'))->withCookie('token', $token);
    }

    public function authMember(Request $request)
    {
        return '';
    }
}