<?php

namespace App\Services;

use App\Models\Settings;
use Doctrine\Common\Cache\PredisCache;
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
                'payment' => [
                    'merchant_id' => $content['merchant_id'],
                    'key'         => $content['pay_api_key'],
                    'cert_path'   => storage_path('app/public/apiclient_cert.pem'), // XXX: 绝对路径！！！！
                    'key_path'    => storage_path('app/public/apiclient_key.pem'),      // XXX: 绝对路径！！！！
                    'notify_url'  => url('/api/wxNotify'),       // 你也可以在下单时单独设置来想覆盖它
                    // 'device_info'     => '013467007045764',
                    // 'sub_app_id'      => '',
                    // 'sub_merchant_id' => '',
                ],
            ];
            self::$app = new Application($options);

            // 修改access_token的缓存驱动为redis
            $predis = app('redis')->connection()->client();
            $cacheDriver = new PredisCache($predis);
            self::$app->cache = $cacheDriver;
        }

        return self::$app;
    }

    public static function __callStatic($name, $arguments)
    {
        return self::app()->$name;
    }
}