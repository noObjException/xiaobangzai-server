<?php

namespace App\Admin\Controllers\Mission;

use App\Models\MissionExpress;

use Encore\Admin\Form;
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

            $content->header('任务详情');

            $content->row(function (Row $row) use ($id) {
                $mission = MissionExpress::findOrFail($id);
                $row->column(6, function (Column $column) use ($mission) {
                    //数据格式化
                    $pay_type = $mission['pay_type'];
                    switch ($pay_type) {
                        case 1:
                            $mission['pay_type'] = '微信支付';
                            break;
                        case 2:
                            $mission['pay_type'] = '余额支付';
                            break;
                        default:
                            break;
                    }
                    $address = json_decode($mission['address'], true);
                    $details = [
                        '订单编号:' => $mission['order_num'],
                        '订单金额:' => '￥' . $mission['total_price'],
                        '追加赏金:' => '￥' . $mission['bounty'],
                        '快递公司:' => $mission['express_com'],
                        '付款方式:' => $mission['pay_type'],
                        '送达时间:' => $mission['arrive_time'],
                        '发单人:'   => $mission->member->nickname,
                        '收货地址:' => $address['realname'] . ' ' . $address['mobile'] . '<br>' .
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
                    $status = $mission['status'];
                    switch ($status) {
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
                            $mission['status'] = '进行中';
                            break;
                        case 3:
                            $mission['status'] = '已完成';
                            break;
                        default:
                            $mission['status'] = '';
                            break;
                    }
                    $rows = [
                        '订单状态:' => $mission['status'],
                    ];
                    $column->append(new Box('订单状态', new Table([], $rows)));
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
            $grid->id('ID')->sortable();

            $grid->column('express_com', '快递公司');
            $grid->column('address', '发单人')->display(function ($address) {
                $address = json_decode($address, true);
                return $address['realname'] . '<br>' . $address['mobile'];
            });
            $grid->column('pay_type_status', '支付方式/状态')->display(function () {
                $pay_type = '';
                switch ($this->pay_type) {
                    case '微信支付':
                        $pay_type = '<span class="label label-success">微信支付</span>';
                        break;
                    case '余额支付':
                        $pay_type = '<span class="label label-danger">余额支付</span>';
                        break;
                }
                $status = '';
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
                }
                return $pay_type . '<br>' . $status;
            });
            $grid->column('bounty', '追加赏金');
            $grid->column('total_price', '支付总价');

            $grid->model()->orderBy('id', 'desc');

            $grid->filter(function ($filter) {
                $filter->useModal();
                $filter->disableidfilter();
                $filter->like('order_num', '订单号');
                $filter->between('created_at', '下单时间')->datetime();
                $filter->equal('status', '状态')->select(['-1' => '已取消', '0' => '待付款', '1' => '待接单', '2' => '配送中', '3' => '已完成']);

            });

            $grid->created_at('下单时间');
        });
    }
}
