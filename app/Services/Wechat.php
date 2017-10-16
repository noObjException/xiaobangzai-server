<?php
namespace App\Services;

use App\Models\Settings;
use EasyWeChat\Foundation\Application;

class Wechat
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
}