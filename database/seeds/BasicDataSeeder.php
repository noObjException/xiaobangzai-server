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
        DB::table('arrive_times')->insert([
            ['title' => '立刻', 'sort' => 0, 'status' => 1],
            ['title' => '马上', 'sort' => 0, 'status' => 1],
            ['title' => '等下', 'sort' => 0, 'status' => 1],
        ]);

        DB::table('express_companys')->insert([
            ['title' => '顺丰快递', 'sort' => 0, 'status' => 1],
            ['title' => '中通快递', 'sort' => 0, 'status' => 1],
            ['title' => '圆通快递', 'sort' => 0, 'status' => 1],
            ['title' => '韵达快递', 'sort' => 0, 'status' => 1],
        ]);

        DB::table('express_types')->insert([
            ['title' => '文件', 'sort' => 0, 'status' => 1],
            ['title' => '数码产品', 'sort' => 0, 'status' => 1],
            ['title' => '办公文具', 'sort' => 0, 'status' => 1],
            ['title' => '鲜花', 'sort' => 0, 'status' => 1],
        ]);

        DB::table('express_weights')->insert([
            ['title' => '1KG', 'sort' => 0, 'status' => 1],
            ['title' => '2KG', 'sort' => 0, 'status' => 1],
            ['title' => '3KG', 'sort' => 0, 'status' => 1],
            ['title' => '4KG', 'sort' => 0, 'status' => 1],
        ]);

        DB::table('member_groups')->insert([
            ['title' => '青铜组', 'sort' => 0, 'status' => 1],
            ['title' => '白银组', 'sort' => 0, 'status' => 1],
            ['title' => '黄金组', 'sort' => 0, 'status' => 1],
        ]);

        DB::table('member_levels')->insert([
            ['title' => '渣渣一级', 'sort' => 0, 'status' => 1],
            ['title' => '渣渣二级', 'sort' => 0, 'status' => 1],
            ['title' => '渣渣三级', 'sort' => 0, 'status' => 1],
        ]);

        $id = DB::table('school_areas')->insertGetId([
            'pid' => 0, 'title' => '桂林理工大学', 'sort' => 0, 'status' => 1,
        ]);
        for ($i = 0; $i < 10; $i++) {
            $pid = DB::table('school_areas')->insertGetId([
                'pid' => $id, 'title' => $i . '栋', 'sort' => 0, 'status' => 1,
            ]);

            $insert = [];
            for ($y = 0; $y < 6; $y++) {
                $insert[] = ['pid' => $pid, 'title' => $y . '号', 'sort' => 0, 'status' => 1];
            }
            DB::table('school_areas')->insert($insert);
        }

        $id = DB::table('schools')->insertGetId([
            'pid' => 0, 'title' => '桂林理工大学', 'sort' => 0, 'status' => 1,
        ]);
        for ($i = 0; $i < 10; $i++) {
            $insert[] = ['pid' => $id, 'title' => $i . '号系', 'sort' => 0, 'status' => 1];

            DB::table('schools')->insert($insert);
        }

        $express = [
            'price'                  => '20.00',
            'credit'                 => '50',
            'base_weight'            => '2',
            'upstairs_price'         => '1',
            'credit_to_money_switch' => '1',
            'credit_to_money'        => '100',
        ];
        DB::table('settings')->insert([
            ['name' => 'GET_EXPRESS_SETTING', 'content' => json_encode($express)],
            ['name' => 'MEMBER_SETTING', 'content' => json_encode(['identify' => 1])],
        ]);
    }
}
