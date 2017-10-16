<?php

namespace App\Http\Controllers;

use App\Models\Members;
use App\Models\Settings;
use App\Services\Wechat;
use EasyWeChat\Foundation\Application;
use Symfony\Component\Translation\Exception\NotFoundResourceException;
use Tymon\JWTAuth\Facades\JWTAuth;

class WechatController extends Controller
{
    /**
     *  微信处理入口
     */
    public function serve()
    {
        $server = Wechat::app()->server;

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
    public function token()
    {
        $openid = session('wechat.oauth_user.id');

        // 用于本地调试
        if (env('APP_DEBUG') && empty($openid)) {
            $openid = request('openid');
        }

        throw_unless($user = Members::where('openid', $openid)->first(), new NotFoundResourceException('没有该用户!'));

        $token = JWTAuth::fromUser($user);

        return redirect('/')->setTargetUrl(env('CLIENT_URL'))
            ->withCookie('token', $token, 3600, $path = '/', env('SESSION_DOMAIN'), env('SESSION_SECURE_COOKIE'), false);
    }
}