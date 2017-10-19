<?php

use Illuminate\Database\Seeder;

class MemberSeeder extends Seeder
{
    public function run()
    {
        factory(App\Models\Members::class, 10)->create();
    }
}