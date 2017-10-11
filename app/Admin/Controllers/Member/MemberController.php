<?php

namespace App\Admin\Controllers\Member;

use App\Admin\Extensions\Staff;
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
            $grid->column('nickname', '昵称');
            $grid->column('mobile', '手机号');

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

            $grid->column('is_staff', '是否设为配送员')->switch([
                'on'  => [
                    'value' => 1,
                    'text'  => '启用',
                    'color' => 'primary',
                ],
                'off' => [
                    'value' => 0,
                    'text'  => '禁用',
                    'color' => 'default',
                ],
            ]);
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

            $groups = MemberGroups::where(['status' => '1'])->orderBy('sort', 'desc')->get();
            $levels = MemberLevels::where(['status' => '1'])->orderBy('sort', 'desc')->get();

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
            $form->select('group_id')->options(array_column($groups->toArray(), 'title', 'id'));
            $form->select('level_id')->options(array_column($levels->toArray(), 'title', 'id'));
            $form->text('is_follow');

            $form->display('created_at', '创建时间');
            $form->display('updated_at', '修改时间');
        });
    }
}
