<?php

use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $wechat           = [
            'app_id'         => 'app_id',
            'app_secret'     => '',
            'token'          => '',
            'encodingaeskey' => '',
        ];
        $express          = [
            'price'                   => '20.00',
            'base_weight'             => '3KG',
            'switch_overweight_price' => '1',
            'overweight_price'        => '2.00',
            'switch_upstairs_price'   => '1',
            'upstairs_price'          => '1.00',
            'switch_reward_point'    => '1',
            'reward_point'           => '100',
            'switch_point_to_money'  => '1',
            'point_to_money'         => '100',
            'rate_collect_basic_fees' => '20',
            'rate_collect_extra_fees' => '20',
        ];
        $member           = [
            'switch_member_identify' => 1,
            'switch_staff_identify'  => 1,
        ];
        $template_message = [
            'switch_create_order'           => '1',
            'create_order'                  => '',
            'switch_pay_order'              => '1',
            'pay_order'                     => '',
            'switch_accept_order_to_staff'  => '1',
            'accept_order_to_staff'         => '',
            'switch_accept_order_to_member' => '1',
            'accept_order_to_member'        => '',
            'switch_completed_order'        => '1',
            'completed_order'               => '',
            'switch_cancel_order'           => '1',
            'cancel_order'                  => '',
            'switch_balance_to_account'     => '1',
            'balance_to_account'            => '',
        ];

        DB::table('settings')->insert([
            ['name' => 'WECHAT_SETTING', 'content' => json_encode($wechat)],
            ['name' => 'GET_EXPRESS_SETTING', 'content' => json_encode($express)],
            ['name' => 'MEMBER_SETTING', 'content' => json_encode($member)],
            ['name' => 'TEMPLATE_MESSAGE_SETTING', 'content' => json_encode($template_message)],
        ]);
    }
}
