<?php

use Illuminate\Database\Seeder;

class MemberSeeder extends Seeder
{
    public function run()
    {
        factory(App\Models\Members::class, 10)->create();
        if (DB::table('member_address')->count() <500) {
            $address = factory(App\Models\MemberAddress::class, 20)->make();
            \App\Models\MemberAddress::insert($address->toArray());
        }
    }
}