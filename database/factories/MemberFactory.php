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
        'gender'      => $faker->numberBetween(0, 1),
        'avatar'      => $faker->imageUrl(50, 50),
        'province'    => $faker->state,
        'city'        => $faker->city,
        'area'        => $faker->address,
        'group_id'    => $faker->randomElement(DB::table('member_groups')->pluck('id')->toArray()),
        'level_id'    => $faker->randomElement(DB::table('member_levels')->pluck('id')->toArray()),
        'is_follow'   => 1,
        'is_staff'    => 1,
        'is_identify' => 1,
        'followed_at' => $faker->dateTimeThisMonth('now', config('app.timezone')),
    ];
});