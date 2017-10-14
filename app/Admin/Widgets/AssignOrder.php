<?php

namespace App\Admin\Widgets;

use App\Models\Members;
use App\Models\MissionExpress;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Widgets\Widget;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Arr;

class AssignOrder extends Widget implements Renderable
{
    /**
     * @var string
     */
    protected $view = 'widgets.assign-order';

    protected $rows = [];

    public function __construct()
    {
        parent::__construct();

        $this->class('table');
    }

    /**
     * Set table rows.
     *
     * @param array $rows
     *
     * @return $this
     */
    public function setRows($rows = [])
    {
        if (Arr::isAssoc($rows)) {
            foreach ($rows as $key => $item) {
                $this->rows[] = [$key, $item];
            }

            return $this;
        }

        $this->rows = $rows;

        return $this;
    }

    public function script()
    {
        return <<<SCRIPT
            $(".assign-order").click(function () {
                var openid = $(this).data('openid')
                var order_id = $('#order-id').val()
                $('#assign-order-modal').modal('hide')
                
                $.ajax({
                    method: 'put',
                    url: '{$this->getUrl()}/' + order_id,
                    data: {
                        openid: openid,
                        _method: 'PUT',
                        _token:LA.token
                    },
                    success: function (data) {
                        $.pjax.reload('#pjax-container');
        
                        if (typeof data === 'object') {
                            if (data.status) {
                                swal(data.message, '', 'success');
                            } else {
                                swal(data.message, '', 'error');
                            }
                        }
                    }
                });
            });
SCRIPT;
    }

    public function getUrl()
    {
        return admin_url('/assignOrder');
    }

    /**
     * Render the table.
     *
     * @return string
     */
    public function render()
    {
        $rows = Members::where('is_staff', 1)->orderBy('id', 'desc')->get(['id', 'realname', 'mobile', 'openid'])->toArray();
        foreach ($rows as $key => &$item) {
            $count         = MissionExpress::where('accept_order_openid', $item['openid'])->count();
            $item['count'] = $count . '单';
        }
        $this->setRows($rows);

        $vars = [
            'title'      => '分配订单',
            'rows'       => $this->rows,
            //            'style'         => [],
            'attributes' => $this->formatAttributes(),
        ];

        Admin::script($this->script());

        return view($this->view, $vars)->render();
    }
}