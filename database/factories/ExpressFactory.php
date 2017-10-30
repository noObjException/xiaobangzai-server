<?php

use Faker\Generator as Faker;

$factory->define(App\Models\MissionExpress::class, function (Faker $faker) {

    $openid         = $faker->randomElement(DB::table('members')->pluck('openid')->toArray());
    $express_type   = $faker->randomElement(DB::table('express_types')->pluck('title')->toArray());
    $express_com    = $faker->randomElement(DB::table('express_companys')->pluck('title')->toArray());
    $express_weight = $faker->randomElement(DB::table('express_weights')->pluck('title')->toArray());
    $arrive_time    = $faker->randomElement(DB::table('arrive_times')->pluck('title')->toArray());
    $price          = $faker->randomFloat(2, 1, 20);
    $bounty         = $faker->randomDigit;
    $times          = $faker->dateTimeThisMonth('now', config('app.timezone'));

    $address = [
        'realname'   => $faker->name,
        'mobile'     => $faker->phoneNumber,
        'college_id' => 1,
        'area_id'    => 2,
        'detail'     => $faker->address,
        'is_default' => 1,
        'college'    => $faker->sentence(1),
        'area'       => $faker->sentence(1),
    ];


    return [
        'status'         => $faker->numberBetween(0, 3),
        'openid'         => $openid,
        'order_num'      => get_order_num('EX'),
        'express_type'   => $express_type,
        'express_com'    => $express_com,
        'express_weight' => $express_weight,
        'arrive_time'    => $arrive_time,
        'bounty'         => $bounty,
        'price'          => $price,
        'total_price'    => $bounty + $price,
        'created_at'     => $times,
        'updated_at'     => $times,
        'remark'         => $faker->sentence(4),
        'pickup_code'    => $faker->numberBetween(100000, 999999),
        'to_staff_money' => $faker->randomFloat(2, 1, 30),
        'pay_type'       => $faker->randomElement(['WECHAT_PAY', 'BALANCE_PAY', 'ADMIN_PAY']),
        'address'        => json_encode($address),
    ];
});