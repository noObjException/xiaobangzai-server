<?php


if (!function_exists('get_setting')) {
    /**
     * 获取设置值
     *
     * @param string $name 设置名
     * @return array    设置内容
     */
    function get_setting($name = ''): array
    {
        if (empty($name)) {
            return '';
        }

        return \App\Models\Settings::where('name', $name)->first()->content;
    }
}