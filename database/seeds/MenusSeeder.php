<?php

use Illuminate\Database\Seeder;

class MenusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $menu_table = config('admin.database.menu_table');

        $pid = DB::table($menu_table)->insertGetId([
            'parent_id' => 0, 'title' => '首页内容设置', 'icon' => 'fa-bars', 'order' => '0', 'uri' => '/',
        ]);
        DB::table($menu_table)->insert([
                ['parent_id' => $pid, 'title' => '轮播图', 'icon' => 'fa-bars', 'uri' => 'swipers', 'order' => '0'],
                ['parent_id' => $pid, 'title' => '导航菜单', 'icon' => 'fa-bars', 'uri' => 'navs', 'order' => '0'],
                ['parent_id' => $pid, 'title' => '滚动公告', 'icon' => 'fa-bars', 'uri' => 'notices', 'order' => '0'],
                ['parent_id' => $pid, 'title' => '版块', 'icon' => 'fa-bars', 'uri' => 'cubes', 'order' => '0'],
            ]
        );


        $pid = DB::table($menu_table)->insertGetId([
            'parent_id' => 0, 'title' => '设置', 'icon' => 'fa-bars', 'order' => '0', 'uri' => '/',
        ]);
        DB::table($menu_table)->insert([
                ['parent_id' => $pid, 'title' => '快递物品类型', 'icon' => 'fa-bars', 'uri' => 'expressTypes', 'order' => '0'],
                ['parent_id' => $pid, 'title' => '快递公司', 'icon' => 'fa-bars', 'uri' => 'expressCompanys', 'order' => '0'],
                ['parent_id' => $pid, 'title' => '送达时间', 'icon' => 'fa-bars', 'uri' => 'arriveTimes', 'order' => '0'],
                ['parent_id' => $pid, 'title' => '快递规格', 'icon' => 'fa-bars', 'uri' => 'expressOptions', 'order' => '0'],
                ['parent_id' => $pid, 'title' => '营业范围', 'icon' => 'fa-bars', 'uri' => 'schoolAreas', 'order' => '0'],
                ['parent_id' => $pid, 'title' => '学校学院', 'icon' => 'fa-bars', 'uri' => 'schools', 'order' => '0'],
            ]
        );


        $pid = DB::table($menu_table)->insertGetId([
            'parent_id' => 0, 'title' => '微信设置', 'icon' => 'fa-bars', 'order' => '0', 'uri' => '/',
        ]);
        DB::table($menu_table)->insert([
                ['parent_id' => $pid, 'title' => '菜单设置', 'icon' => 'fa-bars', 'uri' => 'wechatMenus', 'order' => '0'],
                ['parent_id' => $pid, 'title' => '基本设置', 'icon' => 'fa-bars', 'uri' => 'wechatSettings', 'order' => '0'],
                ['parent_id' => $pid, 'title' => '小程序设置', 'icon' => 'fa-bars', 'uri' => 'miniProgramSetting', 'order' => '0'],
                ['parent_id' => $pid, 'title' => '模板消息设置', 'icon' => 'fa-bars', 'uri' => 'wechatTemplates', 'order' => '0'],
            ]
        );


        $pid = DB::table($menu_table)->insertGetId([
            'parent_id' => 0, 'title' => '会员管理', 'icon' => 'fa-bars', 'order' => '0', 'uri' => '/',
        ]);
        DB::table($menu_table)->insert([
                ['parent_id' => $pid, 'title' => '会员列表', 'icon' => 'fa-bars', 'uri' => 'members', 'order' => '0'],
                ['parent_id' => $pid, 'title' => '会员分组', 'icon' => 'fa-bars', 'uri' => 'memberGroups', 'order' => '0'],
                ['parent_id' => $pid, 'title' => '会员等级', 'icon' => 'fa-bars', 'uri' => 'memberLevels', 'order' => '0'],
                ['parent_id' => $pid, 'title' => '积分记录', 'icon' => 'fa-bars', 'uri' => 'pointRecords', 'order' => '0'],
                ['parent_id' => $pid, 'title' => '设置', 'icon' => 'fa-bars', 'uri' => 'memberSettings', 'order' => '0'],
                ['parent_id' => $pid, 'title' => '学生认证申请', 'icon' => 'fa-bars', 'uri' => 'memberIdentifies', 'order' => '0'],
            ]
        );


        $pid = DB::table($menu_table)->insertGetId([
            'parent_id' => 0, 'title' => '取快递任务', 'icon' => 'fa-bars', 'order' => '0', 'uri' => '/',
        ]);
        DB::table($menu_table)->insert([
                ['parent_id' => $pid, 'title' => '任务列表', 'icon' => 'fa-bars', 'uri' => 'express', 'order' => '0'],
                ['parent_id' => $pid, 'title' => '设置', 'icon' => 'fa-bars', 'uri' => 'expressSettings', 'order' => '0'],
            ]
        );
    }
}
