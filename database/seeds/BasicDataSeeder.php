<?php

use Illuminate\Database\Seeder;

class BasicDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\Swipers::class, 4)->create();
        factory(App\Models\Navs::class, 4)->create();
        factory(App\Models\Notices::class, 4)->create();
        factory(App\Models\Cubes::class, 3)->create();

        factory(App\Models\ArriveTimes::class, 4)->create();
        factory(App\Models\ExpressWeights::class, 6)->create();
        factory(App\Models\ExpressCompanys::class, 20)->create();
        factory(App\Models\ExpressTypes::class, 20)->create();

        factory(App\Models\MemberLevels::class, 4)->create();
        factory(App\Models\MemberGroups::class, 4)->create();

        $faker = Faker\Factory::create();
        for ($x = 0; $x < 3; $x++) {
            $id = DB::table('school_areas')->insertGetId([
                'pid' => 0, 'title' => $faker->sentence(2), 'sort' => 0, 'status' => 1,
            ]);
            for ($i = 0; $i < 10; $i++) {
                $pid = DB::table('school_areas')->insertGetId([
                    'pid' => $id, 'title' => $faker->sentence(1) . '栋', 'sort' => 0, 'status' => 1,
                ]);

                $insert = [];
                for ($y = 0; $y < 6; $y++) {
                    $insert[] = ['pid' => $pid, 'title' => $faker->sentence(1) . '号', 'sort' => 0, 'status' => 1];
                }
                DB::table('school_areas')->insert($insert);
            }
        }

        for ($x = 0; $x < 3; $x++) {
            $id = DB::table('schools')->insertGetId([
                'pid' => 0, 'title' => $faker->sentence(2), 'sort' => 0, 'status' => 1,
            ]);
            for ($i = 0; $i < 10; $i++) {
                $insert[] = ['pid' => $id, 'title' => $faker->sentence(1) . '系', 'sort' => 0, 'status' => 1];

                DB::table('schools')->insert($insert);
            }
        }
    }
}
