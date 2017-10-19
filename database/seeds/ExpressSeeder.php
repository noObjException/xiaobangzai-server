<?php

use Illuminate\Database\Seeder;

class ExpressSeeder extends Seeder
{
    public function run()
    {
        $insert = factory(App\Models\MissionExpress::class, 200)->make();

        \App\Models\MissionExpress::insert($insert->toArray());
    }
}