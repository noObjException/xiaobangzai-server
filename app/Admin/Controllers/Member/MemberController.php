<?php

namespace App\Admin\Controllers\Member;

use App\Models\MemberGroups;
use App\Models\MemberLevels;
use App\Models\Members;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class MemberController extends Controller
{
    use ModelForm;

    /**
     * Index interface.
     *
     * @return Content
     */
    public function index()
    {
        return Admin::content(function (Content $content) {

            $content->header('会员');

            $content->body($this->grid());
        });
    }

    /**
     * Edit interface.
     *
     * @param $id
     * @return Content
     */
    public function edit($id)
    {
        return Admin::content(function (Content $content) use ($id) {

            $content->header('会员');

            $content->body($this->form()->edit($id));
        });
    }

    /**
     * Create interface.
     *
     * @return Content
     */
    public function create()
    {
        return Admin::content(function (Content $content) {

            $content->header('会员');

            $content->body($this->form());
        });
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Admin::grid(Members::class, function (Grid $grid) {

            $grid->id('ID')->sortable();

            $grid->column('avatar', '头像')->image('', 40, 40);
            $grid->column('openid', 'openid');

            $grid->column('nickname_mobile', '昵称/手机号')->display(function () {
                return str_limit($this->nickname, 6) . '<br>'
                    . $this->mobile;
            });

            $grid->column('level_group', '等级/分组')->display(function () {
                return $this->level->title . '<br>'
                    . $this->group->title;
            });

            $grid->column('credit_balance', '积分/余额')->display(function () {
                return '<span class="label label-success">' . $this->credit . '</span>' . '<br>'
                    . '<span class="label label-success">' . $this->balance . '</span>';
            });

            $grid->column('times', '注册/修改时间')->display(function () {
                return $this->created_at . '<br>' . $this->updated_at;
            });

            // 用switchGroup一定要在表单中建对应的switch
            $states = [
                'on'  => ['value' => 1, 'text' => '启用', 'color' => 'primary'],
                'off' => ['value' => 0, 'text' => '禁用', 'color' => 'default'],
            ];
            $grid->column('资格')->switchGroup([
                'is_staff'    => '配送员',
                'is_identify' => '通过认证',
            ], $states);

            $grid->model()->orderBy('id', 'desc');

            $grid->filter(function ($filter) {

                // 设置created_at字段的范围查询
                $filter->like('openid', 'openid');
                $filter->between('created_at', '注册时间')->datetime();
                $filter->between('updated_at', '修改时间')->datetime();
            });
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(Members::class, function (Form $form) {

            $form->display('id', 'ID');

            $form->text('openid');
            $form->text('realname');
            $form->text('nickname');
            $form->text('mobile');
            $form->number('credit');
            $form->currency('balance');
            $form->image('avatar');
            $form->text('gender');
            $form->text('province');
            $form->text('city');
            $form->text('area');

            $form->select('group_id')
                ->options(MemberGroups::where(['status' => '1'])->orderBy('sort', 'desc')->pluck('title', 'id'));

            $form->select('level_id')
                ->options(MemberLevels::where(['status' => '1'])->orderBy('sort', 'desc')->pluck('title', 'id'));

            $form->text('is_follow');

            $states = $states = [
                'on'  => ['value' => 1, 'text' => '启用', 'color' => 'primary'],
                'off' => ['value' => 0, 'text' => '禁用', 'color' => 'default'],
            ];
            $form->switch('is_staff', '设为配送员')->states($states);
            $form->switch('is_identify', '通过认证')->states($states);

            $form->display('created_at', '创建时间');
            $form->display('updated_at', '修改时间');

            $form->saved(function (Form $form) {
                $id     = $form->model()->id;
                $avatar = $form->model()->avatar;

                if (!starts_with($avatar, 'http')) {
                    Members::where('id', $id)->update(['avatar' => config('filesystems.disks.admin.url') . '/' . $avatar]);
                }
            });
        });
    }
}
