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

        return \App\Models\Settings::where('name', $name)->first()->content ?: [];
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
        $data = [
            'WECHAT_PAY'  => '微信支付',
            'BALANCE_PAY' => '余额支付',
            'ADMIN_PAY'   => '后台支付',
        ];

        return $data[$name] ?: '';
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
        try {
            $user = \Tymon\JWTAuth\Facades\JWTAuth::parseToken()->authenticate();
        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return response()->json(['TOKEN_EXPIRED'], $e->getStatusCode());
        }

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
        return current_member_info()->openid;
    }
}