<?php

namespace App\Admin\Controllers\Mission;

use App\Admin\Extensions\AssignOrder;
use App\Admin\Extensions\Pay;
use App\Admin\Widgets\AssignOrder as AssignOrderWidget;
use App\Models\MissionExpress;

use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Column;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use Encore\Admin\Layout\Row;
use Encore\Admin\Widgets\Box;
use Encore\Admin\Widgets\Table;

class ExpressController extends Controller
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

            $content->header('任务列表');

            $content->row($this->grid());

            $content->row(new AssignOrderWidget());
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

            $content->header('任务详情');

            $content->row(function (Row $row) use ($id) {
                $mission = MissionExpress::findOrFail($id);
                $row->column(6, function (Column $column) use ($mission) {
                    $address = json_decode($mission['address'], true);
                    $details = [
                        '订单编号:'  => $mission['order_num'],
                        '订单金额:'  => '￥' . $mission['total_price'],
                        '追加赏金:'  => '￥' . $mission['bounty'],
                        '快递公司:'  => $mission['express_com'],
                        '付款方式:'  => get_pay_type($mission['pay_type']),
                        '送达时间:'  => $mission['arrive_time'],
                        '发单人:'   => $mission->member->nickname,
                        '收货地址:'  => $address['realname'] . ' ' . $address['mobile'] . '<br>' .
                            $address['college'] . ' ' . $address['area'],
                        '备注:   ' => $mission['remark'],
                    ];
                    $column->append(new Box('任务信息', new Table([], $details)));

                    $times['下单时间:'] = $mission['created_at'];
                    if (!empty($mission['pay_time'])) {
                        $times['支付时间:'] = $mission['pay_time'];
                    }
                    if (!empty($mission['start_time'])) {
                        $times[' 开始时间:'] = $mission['start_time'];
                    }
                    if (!empty($mission['finish_time'])) {
                        $times['完成时间:'] = $mission['finish_time'];
                    }
                    $column->append(new Box('任务跟踪', new Table([], $times)));
                });


                $row->column(4, function (Column $column) use ($mission) {
                    switch ($mission['status']) {
                        case -1:
                            $mission['status'] = '已关闭';
                            break;
                        case 0:
                            $mission['status'] = '待付款';
                            break;
                        case 1:
                            $mission['status'] = '待接单';
                            break;
                        case 2:
                            $mission['status'] = '配送中';
                            break;
                        case 3:
                            $mission['status'] = '已完成';
                            break;
                        default:
                            $mission['status'] = '';
                            break;
                    }
                    $status = [
                        '订单状态:' => $mission['status'],
                    ];
                    $column->append(new Box('订单状态', new Table([], $status)));

                    // 物品信息
                    $express_info = [
                        '物品类型:' => $mission['express_type'],
                        '物品重量:' => $mission['express_weight'],
                    ];
                    $column->append(new Box('物品信息', new Table([], $express_info)));

                    // 配送员信息
                    if(!empty($mission['accept_order_openid'])) {
                        $staff_info = [
                            '头像:' => "<img src=\"{$mission->staff->avatar}\" width='50'/>",
                            '姓名:' => $mission->staff->realname,
                            '手机:' => $mission->staff->mobile,
                        ];
                        $column->append(new Box('配送员信息', new Table([], $staff_info)));
                    }
                });
            });
        });
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Admin::grid(MissionExpress::class, function (Grid $grid) {

            $grid->disableCreation();

            $grid->column('member.avatar', '下单人头像')->image('', 40, 40);
            $grid->column('member.nickname', '下单人昵称')->limit(6);

            $grid->column('express_info', '物品信息')->display(function () {
                return '订单编号: ' . $this->order_num . '<br>' .
                        '物品类型: ' . $this->express_type . '<br>' .
                        '物品重量: ' . $this->express_weight . '<br>' .
                        '提货号码: ' . ($this->pickup_code ?: '无') . '<br>' .
                        '送达时间: ' . $this->arrive_time;
            });

            $grid->column('cost_detail', '费用明细')->display(function () {
                $extra_costs = json_decode($this->extra_costs, true);
                $info        = '基本费用: ￥' . $this->price . '<br>';

                if (!empty($this->bounty) && $this->bounty > 0) {
                    $info .= '跑腿赏金: ￥' . $this->bounty . '<br>';
                }
                if (!empty($extra_costs['upstairs_price'])) {
                    $info .= '上楼加价: ￥' . number_format($extra_costs['upstairs_price'], 2) . '<br>';
                }

                return $info;
            });

            $grid->column('pay_type_status', '支付方式/状态')->display(function () {
                switch ($this->status) {
                    case -1:
                        $status = '<span class="label label-default">已关闭</span>';
                        break;
                    case 0:
                        $status = '<span class="label label-danger">待付款</span>';
                        break;
                    case 1:
                        $status = '<span class="label label-success">待接单</span>';
                        break;
                    case 2:
                        $status = '<span class="label label-success">配送中</span>';
                        break;
                    case 3:
                        $status = '<span class="label label-success">已完成</span>';
                        break;
                    default:
                        $status = '';
                        break;
                }

                switch ($this->pay_type) {
                    case 'WECHAT_PAY':
                        $pay_type = '<span class="label label-success">微信支付</span>';
                        break;
                    case 'BALANCE_PAY':
                        $pay_type = '<span class="label label-danger">余额支付</span>';
                        break;
                    case 'ADMIN_PAY':
                        $pay_type = '<span class="label label-danger">后台付款</span>';
                        break;
                    default:
                        $pay_type = '';
                        break;
                }

                return $status . '<br>' . $pay_type;
            });

            $grid->column('total_price', '支付总价')->display(function ($total_price) {
                return '￥ ' . $total_price;
            });

            $grid->column('remark', '下单留言')->display(function ($remark) {
                return $remark ?: '无';
            })->style('width:150px');

            $grid->column('times', '下单时间/付款时间')->display(function () {
                return $this->created_at . '<br>' . $this->pay_time;
            });

            $grid->actions(function ($actions) {
                $actions->disableDelete();

                $row = $actions->row;

                if ($row['status'] === 0) {
                    $actions->append(new Pay($actions->getKey()));
                }

                if ($row['status'] === 1) {
                    $actions->append(new AssignOrder($actions->getKey()));
                }

            });

            $grid->model()->orderBy('id', 'desc');
            $grid->model()->withTrashed();

            $grid->filter(function ($filter) {

                $filter->useModal();
                $filter->disableidfilter();
                $filter->like('order_num', '订单号');
                $filter->like('member.nickname', '下单人昵称');
                $filter->like('address', '收获人信息');
                $filter->between('created_at', '下单时间')->datetime();
                $filter->equal('status', '状态')->select(['-1' => '已取消', '0' => '待付款', '1' => '待接单', '2' => '配送中', '3' => '已完成']);

            });
        });
    }
}
