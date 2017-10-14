<?php
namespace App\Admin\Extensions;

use Encore\Admin\Admin;

/**
 * "分配订单"按钮行扩展
 *
 * Class Pay
 * @package App\Admin\Extensions
 */
class AssignOrder
{
    protected $id;

    public function __construct($id)
    {
        $this->id = $id;
    }

    protected function script()
    {
        return <<<SCRIPT

$('.grid-row-assign-order').unbind('click').click(function() {

    var id = $(this).data('id');

    $('#order-id').val(id)
    
});

SCRIPT;
    }

    protected function render()
    {
        Admin::script($this->script());

        return "<br><a class='btn btn-xs btn-success grid-row-assign-order' data-toggle='modal' data-target='#assign-order-modal' data-id='{$this->id}'>分配订单</a>";
    }

    public function __toString()
    {
        return $this->render();
    }
}