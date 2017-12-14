<?php

namespace App\Http\Controllers;

use App\Models\Members;
use App\Services\Wechat;
use Illuminate\Http\Request;
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

        $server->push(function ($message) {
            switch ($message['MsgType']) {
                case 'event':
                    return '收到事件消息';
                    break;
                case 'text':
                    return '收到文字消息';
                    break;
                case 'image':
                    return '收到图片消息';
                    break;
                case 'voice':
                    return '收到语音消息';
                    break;
                case 'video':
                    return '收到视频消息';
                    break;
                case 'location':
                    return '收到坐标消息';
                    break;
                case 'link':
                    return '收到链接消息';
                    break;
                // ... 其它消息
                default:
                    return '收到其它消息';
                    break;
            }
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
            ->withCookie('token', $token, 0, $path = '/', env('SESSION_DOMAIN'), env('SESSION_SECURE_COOKIE'), false);
    }

    /**
     * 小程序token
     *
     * @param Request $request
     * @return \EasyWeChat\Support\Collection
     */
    public function wxappToken(Request $request)
    {
        $code     = $request->get('code');
        $userInfo = $request->get('userInfo');
        $userInfo = json_decode($userInfo, true);

        $miniProgram = Wechat::app()->mini_program;

        $wx_session = $miniProgram->sns->getSessionKey($code);

        $encryptedData = $miniProgram->encryptor->decryptData($wx_session->session_key, $userInfo['iv'], $userInfo['encryptedData']);

        $user = Members::updateOrCreate([
            'wx_mini_openid' => $encryptedData['openId']
        ],[
            'wx_mini_openid' => $encryptedData['openId'],
            'wx_union_id'    => isset($encryptedData['unionId']) ? ($encryptedData['unionId']) : '',
            'nickname'       => $encryptedData['nickName'],
            'avatar'         => $encryptedData['avatarUrl'],
            'area'           => $encryptedData['country'],
            'province'       => $encryptedData['province'],
            'city'           => $encryptedData['city'],
            'gender'         => $encryptedData['gender'],
            'group_id'       => 1,
            'level_id'       => 1,
            'follow_channel' => 'WX_MINI_PROGRAM'
        ]);

        $data = JWTAuth::fromUser($user);

        return response()->json(compact('data'));
    }

    public function wxapp()
    {
        $signature = request('signature');
        $timestamp = request('timestamp');
        $nonce     = request('nonce');

        $token  = get_setting('MINI_PROGRAM_SETTING')['token'];
        $tmpArr = [$token, $timestamp, $nonce];

        sort($tmpArr, SORT_STRING);
        $tmpStr = implode($tmpArr);
        $tmpStr = sha1($tmpStr);

        if ($tmpStr == $signature) {
            return 'true';
        } else {
            return false;
        }
    }
}