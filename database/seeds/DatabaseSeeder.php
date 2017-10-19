<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard(); //解除模型的批量填充限制

        $this->call(MenusSeeder::class);
        $this->call(BasicDataSeeder::class);
        $this->call(SettingSeeder::class);
        $this->call(MemberSeeder::class);
        $this->call(ExpressSeeder::class);

        Model::reguard();
    }
}
