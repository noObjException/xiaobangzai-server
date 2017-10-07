<?php

namespace App\Http\Controllers;

use App\Models\Members;
use App\Models\Settings;
use EasyWeChat\Foundation\Application;
use Illuminate\Support\Facades\Log;
use Tymon\JWTAuth\Facades\JWTAuth;

class WechatController extends Controller
{
    protected static $app;

    /**
     *  获取EasyWeChat微信对象
     *
     * @return Application
     */
    public static function app(): Application
    {
        // 获取配置
        if (!isset(self::$app)) {
            $setting = Settings::where(['name' => 'WECHAT_SETTING'])->first();
            $content = $setting['content'];
            if (!$content) {
                throw new \InvalidArgumentException('请配置微信选项!');
            }

            $options   = [
                'debug'   => true,
                'app_id'  => $content['app_id'],
                'secret'  => $content['app_secret'],
                'token'   => $content['token'],
                'aes_key' => $content['encodingaeskey'],
                'log'     => [
                    'level' => 'debug',
                    'file'  => storage_path('/logs/wechat/' . date('Y-m-d') . '.log'),
                ],
            ];
            self::$app = new Application($options);
        }

        return self::$app;
    }

    /**
     *  微信处理入口
     */
    public function serve()
    {
        $server = self::app()->server;

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
        $openid = session('wechat.oauth_user.id');
        Log::Info('openid---' . $openid);
        $user = Members::first();
        Log::Info('$user----' . $user);
        $token = JWTAuth::fromUser($user);

        return redirect('/')->setTargetUrl(env('CLIENT_URL'))
            ->withCookie('token', $token, 3600, $path = '/', env('SESSION_DOMAIN'), env('SESSION_SECURE_COOKIE'), false);
    }

    public function authMember()
    {
        $user = JWTAuth::parseToken()->authenticate();

        return response()->json(compact('user'));
    }

    public static function __callStatic($name, $arguments)
    {
        return self::app()->$name;
    }
}