<?php
namespace App\Api;

use App\Models\Settings;
use EasyWeChat\Foundation\Application;

trait WechatHelpers
{
    /**
     *  获取esaywechat微信对象
     *
     * @return Application
     */
    public function getWechat(): Application
    {
        // 获取配置
        $setting = Settings::where(['name' => 'WECHAT_SETTING'])->first();
        $content = $setting['content'];

        $options = [
            'debug'   => true,
            'app_id'  => $content['app_id'],
            'secret'  => $content['app_secret'],
            'token'   => $content['token'],
            'aes_key' => $content['encodingaeskey'],
            'log'     => [
                'level' => 'debug',
                'file'  => storage_path('/logs/wechat'.date('Y-m-d').'.log'),
            ]
        ];

        return new Application($options);
    }

    /**
     * @return \EasyWeChat\Server\Guard
     */
    public function getServer()
    {
        return $this->getWechat()->server;
    }

    /**
     * @return \EasyWeChat\User\User
     */
    public function getUser()
    {
        return $this->getWechat()->user;
    }
}