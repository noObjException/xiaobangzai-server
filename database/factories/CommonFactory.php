<?php

use Faker\Generator as Faker;


$factory->define(App\Models\Swipers::class, function (Faker $faker) {
    return [
        'name'   => $faker->sentence(2),
        'url'    => env('CLIENT_URL'),
        'image'  => $faker->imageUrl(),
        'sort'   => 0,
        'status' => 1,
        'desc'   => $faker->sentence(4),
    ];
});

$factory->define(App\Models\Navs::class, function (Faker $faker) {
    return [
        'title'  => $faker->sentence(1),
        'url'    => env('CLIENT_URL'),
        'image'  => $faker->imageUrl(40, 40),
        'sort'   => 0,
        'status' => 1,
    ];
});

$factory->define(App\Models\Notices::class, function (Faker $faker) {
    return [
        'title'   => $faker->sentence(1),
        'url'     => env('CLIENT_URL'),
        'sort'    => 0,
        'status'  => 1,
        'content' => $faker->sentence(20),
    ];
});

$factory->define(App\Models\Cubes::class, function (Faker $faker) {
    return [
        'title'  => $faker->sentence(1),
        'url'    => env('CLIENT_URL'),
        'image'  => $faker->imageUrl(40, 40),
        'sort'   => 0,
        'status' => 1,
        'desc'   => $faker->sentence(2),
    ];
});

$factory->define(App\Models\ExpressTypes::class, function (Faker $faker) {
    return [
        'title'  => $faker->sentence(1),
        'sort'   => 0,
        'status' => 1,
    ];
});


$factory->define(App\Models\ExpressCompanys::class, function (Faker $faker) {
    return [
        'title'  => $faker->sentence(2),
        'sort'   => 0,
        'status' => 1,
        'name'   => $faker->sentence(2),
    ];
});

$factory->define(App\Models\ExpressWeights::class, function (Faker $faker) {
    return [
        'title'  => $faker->sentence(1) . 'KG',
        'sort'   => 0,
        'status' => 1,
    ];
});

$factory->define(App\Models\ArriveTimes::class, function (Faker $faker) {
    return [
        'title'  => $faker->sentence(1),
        'sort'   => 0,
        'status' => 1,
    ];
});

$factory->define(App\Models\MemberGroups::class, function (Faker $faker) {
    return [
        'title'  => $faker->sentence(1),
        'sort'   => 0,
        'status' => 1,
    ];
});

$factory->define(App\Models\MemberLevels::class, function (Faker $faker) {
    return [
        'title'  => $faker->sentence(1),
        'sort'   => 0,
        'status' => 1,
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
        'is_default' => 0,
    ];
});

