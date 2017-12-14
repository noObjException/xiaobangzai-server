<?php
namespace App\Services;


use App\Models\MissionExpress;
use EasyWeChat\Factory;

class WechatPay
{
    protected $model;

    public function __construct(MissionExpress $model)
    {
        $this->model = $model;
    }

    public function make()
    {
        $model = $this->model;
        $account = get_setting('WECHAT_SETTING');

        $options = [
            // 前面的appid什么的也得保留哦
            'app_id'             => $account['app_id'],
            'merchant_id'        => $account['merchant_id'],
            'key'                => $account['pay_api_key'],
            'cert_path'          => storage_path('app/public/apiclient_cert.pem'), // XXX: 绝对路径！！！！
            'key_path'           => storage_path('app/public/apiclient_key.pem'),      // XXX: 绝对路径！！！！
            'notify_url'         => url('/api/wxNotify'),     // 你也可以在下单时单独设置来想覆盖它
            // 'device_info'     => '013467007045764',
            // 'sub_app_id'      => '',
            // 'sub_merchant_id' => '',
            // ...
        ];

        $payment = Factory::payment($options);

        $jssdk = $payment->jssdk;

        $result  = $payment->order->unify([
            'trade_type'   => 'JSAPI', // JSAPI，NATIVE，APP...
            'body'         => '代取快递收费',
            'detail'       => '代取快递收费',
            'out_trade_no' => $model->order_num,
            'total_fee'    => $model->total_price * 100, // 单位：分
            'openid'       => current_member_openid(),
        ]);

        info('result:'.$result);

        if ($result->return_code == 'SUCCESS' && $result->result_code == 'SUCCESS') {
            return $jssdk->sdkConfig($result->prepay_id);
        }

        return false;
    }
}