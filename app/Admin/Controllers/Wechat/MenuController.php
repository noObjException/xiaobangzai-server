<?php

namespace App\Admin\Controllers\Wechat;

use App\Models\WechatMenus as Menus;
use App\Services\Wechat;
use Encore\Admin\Form;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Column;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use Encore\Admin\Layout\Row;
use Encore\Admin\Tree;
use Encore\Admin\Widgets\Box;
use Illuminate\Support\MessageBag;

class MenuController extends Controller
{
    use ModelForm;

    public function index()
    {
        return Admin::content(function (Content $content) {
            $content->header('自定义菜单');

            $content->row(function (Row $row) {
                $row->column(6, $this->treeView()->render());

                $row->column(6, function (Column $column) {
                    $form = new \Encore\Admin\Widgets\Form();
                    $form->action(admin_url('wechatMenus'));

                    $form->number('sort', '排序');
                    $form->select('pid', '上级菜单')->options(Menus::selectOptions());
                    $form->text('title', '菜单名')->rules('required');
                    $form->text('url', '菜单链接');

                    $form->saving(function ($form) {
                        // 检查是否超过菜单设置数量
                        return $this->checkCount($form);
                    });
                    $column->append((new Box('添加', $form))->style('success'));
                });
            });

            $content->row(function (Row $row) {
                $row->column(6, function (Column $column) {
                    $url = admin_url('setWechatMenus');
                    $column->append("<a href=\"$url\" class=\"btn btn-success\">推送到微信端</a>");
                });
            });
        });
    }

    /**
     *  推送菜单设置到微信端
     *
     * @param Menus $menus
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function setMenu(Menus $menus)
    {
        $buttons = [];
        $parents = $menus->where('pid', 0)->get();
        foreach ($parents as $parent) {
            $button    = [
                "type" => "view",
                "name" => $parent->title,
            ];
            $childrens = $menus->where('pid', $parent->id)->get()->toArray();
            if (empty($childrens)) {
                $button['url'] = url($parent->url);
            } else {
                $sub_button = [];
                foreach ($childrens as $children) {
                    $sub_button[] = [
                        "type" => "view",
                        "name" => $children['title'],
                        "url"  => url($children['url']),
                    ];
                }
                $button['sub_button'] = $sub_button;
            }
            $buttons[] = $button;
        }

        $app  = Wechat::app();
        $menu = $app->menu;
        $menu->create($buttons);

        $success = new MessageBag([
            'title'   => '推送成功',
            'message' => '',
        ]);

        return back()->with(compact('success'));
    }

    /**
     * Redirect to edit page.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function show($id)
    {
        return redirect()->action(
            '\App\Admin\Controllers\Wechat\MenuController@edit', ['id' => $id]
        );
    }

    private function treeView()
    {
        return Menus::tree(function (Tree $tree) {
            $tree->disableCreate();

            $tree->branch(function ($branch) {
                $payload = "&nbsp;<strong>{$branch['title']}</strong>";

                if (!isset($branch['children'])) {
                    $uri = url($branch['url']);

                    $payload .= "&nbsp;&nbsp;&nbsp;<a href=\"$uri\" class=\"dd-nodrag\">$uri</a>";
                }

                return $payload;
            });
        });
    }

    /**
     * Edit interface.
     *
     * @param string $id
     *
     * @return Content
     */
    public function edit($id)
    {
        return Admin::content(function (Content $content) use ($id) {
            $content->header('菜单');

            $content->row($this->form()->edit($id));
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    public function form()
    {
        return Menus::form(function (Form $form) {
            $form->display('id', 'ID');

            $form->number('sort', '排序');
            $form->select('pid', '上级菜单')->options(Menus::selectOptions());
            $form->text('title', '菜单名')->rules('required');
            $form->text('url', '菜单链接');

            $form->display('created_at', '创建时间');
            $form->display('updated_at', '修改时间');

            $form->saving(function ($form) {
                return $this->checkCount($form);
            });
        });
    }

    public function checkCount($form)
    {
        //不是新增就不做检测
        if ($form->_method == 'PUT') {
            return true;
        }

        $error = [
            'title'   => '',
            'message' => '',
        ];

        $menus   = new Menus();
        $parents = $menus->where('pid', 0)->count();
        if ($parents >= 3 && $form->pid == 0) {
            $error['title']   = '超过可创建菜单数量';
            $error['message'] = '顶级菜单最多只能创建3个';
        }
        $childrens = $menus->where('pid', $form->pid)->count();
        if ($childrens >= 5) {
            $error['title']   = '超过可创建菜单数量';
            $error['message'] = '子菜单最多只能创建5个';
        }

        if (empty($error['title']) && empty($error['message'])) {
            return true;
        }

        $error = new MessageBag($error);

        return back()->with(compact('error'));
    }
}
