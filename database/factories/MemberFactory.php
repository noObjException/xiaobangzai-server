<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Members::class, function (Faker $faker) {
    return [
        'openid'      => $faker->uuid,
        'realname'    => $faker->name,
        'nickname'    => $faker->sentence(2),
        'mobile'      => $faker->phoneNumber,
        'credit'      => $faker->randomDigit,
        'balance'     => $faker->randomFloat(2, 1, 200),
        'status'      => 1,
        'gender'      => $faker->numberBetween(1, 2),
        'avatar'      => $faker->imageUrl(50, 50),
        'province'    => $faker->state,
        'city'        => $faker->city,
        'area'        => $faker->sentence(2),
        'group_id'    => $faker->randomElement(DB::table('member_groups')->pluck('id')->toArray()),
        'level_id'    => $faker->randomElement(DB::table('member_levels')->pluck('id')->toArray()),
        'is_follow'   => 1,
        'is_staff'    => 1,
        'is_identify' => 1,
        'followed_at' => $faker->dateTimeThisMonth('now', config('app.timezone')),
    ];
});

$factory->define(App\Models\MemberAddress::class, function (Faker $faker) {
    $college_id = $faker->randomElement(DB::table('school_areas')->where('pid', '0')->pluck('id')->toArray());
    $area_id    = $faker->randomElement(DB::table('school_areas')->where('pid', $college_id)->pluck('id')->toArray());

    return [
        'realname'   => $faker->name,
        'openid'     => $faker->randomElement(DB::table('members')->pluck('openid')->toArray()),
        'mobile'     => $faker->phoneNumber,
        'college_id' => $college_id,
        'area_id'    => $area_id,
        'detail'     => $faker->sentence(2),
        'is_default' => 1,
    ];
});