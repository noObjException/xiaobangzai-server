<?php

if (!function_exists('get_setting')) {
    /**
     * 获取设置值
     *
     * @param string $name 设置名
     * @return array    设置内容
     */
    function get_setting(string $name = ''): array
    {
        if (empty($name)) {
            return [];
        }

        $model = \App\Models\Settings::where('name', $name)->first();

        if (empty($model)) {
            return [];
        }

        $content = $model->content;

        return !empty($content) ? $content : [];
    }
}

if (!function_exists('get_order_num')) {
    /**
     * 生成订单号
     *
     * @param $business_code
     * @return string
     */
    function get_order_num(string $business_code): string
    {
        return $business_code
            . date('YmdHi')
            . substr(microtime(), 2, 3)
            . sprintf('%02d', rand(0, 99));
    }
}

if (!function_exists('get_pay_type')) {
    /**
     * 获取支付方式
     *
     * @param $name
     * @return string
     */
    function get_pay_type(string $name): string
    {
        if (empty($name)) {
            return '';
        }

        $data = [
            'WECHAT_PAY'  => '微信支付',
            'BALANCE_PAY' => '余额支付',
            'ADMIN_PAY'   => '后台支付',
        ];

        return isset($data[$name]) ? $data[$name] : '';
    }
}

if (!function_exists('current_member_info')) {
    /**
     * 获取当前登录会员信息
     *
     * @param null $key
     * @param null $default
     * @return mixed
     */
    function current_member_info($key = null, $default = null)
    {
        $user = \Tymon\JWTAuth\Facades\JWTAuth::parseToken()->authenticate();

        if (is_null($key)) {
            return $user;
        }

        $value = $user->__get($key);

        return is_null($value) ? value($default) : $value;
    }
}

if (!function_exists('current_member_openid')) {
    /**
     * 获取当前登录用户openid
     *
     * @return string
     */
    function current_member_openid(): string
    {
        return current_member_info()->openid ?? '';
    }
}

if (!function_exists('current_user_id')) {
    /**
     * 获取当前登录用户openid
     * @return int
     */
    function current_user_id(): int
    {
        return current_member_info()->id ?? 0;
    }
}

if (!function_exists('order_status_to_num')) {
    /**
     * @param string $name
     * @return int
     */
    function order_status_to_num(string $name): int
    {
        if (empty($name)) {
            return null;
        }

        $data = [
            'WAIT_PAY'   => 0,
            'WAIT_ORDER' => 1,
            'PROCESSING' => 2,
            'COMPLETED'  => 3,
        ];

        return isset($data[$name]) ? $data[$name] : null;
    }
}

if (!function_exists('client_url')) {
    /**
     * 生成客户端url
     *
     * @param $url
     * @return string
     */
    function client_url(string $url): string
    {
        return env('CLIENT_URL') . '/#/' . $url;
    }
}