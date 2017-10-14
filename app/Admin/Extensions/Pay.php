<?php
namespace App\Admin\Extensions;

use Encore\Admin\Admin;

/**
 * "确认支付"按钮行扩展
 *
 * Class Pay
 * @package App\Admin\Extensions
 */
class Pay
{
    protected $id;

    public function __construct($id)
    {
        $this->id = $id;
    }

    public function getUrl()
    {
        return admin_url('/expressPay');
    }

    protected function script()
    {
        return <<<SCRIPT

$('.grid-row-pay').unbind('click').click(function() {

    var id = $(this).data('id');

    swal({
      title: "确认付款?",
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: "#DD6B55",
      confirmButtonText: "确认",
      closeOnConfirm: false,
      cancelButtonText: "取消"
    },
    function(){
        $.ajax({
            method: 'put',
            url: '{$this->getUrl()}/' + id,
            data: {
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
});

SCRIPT;
    }

    protected function render()
    {
        Admin::script($this->script());

        return "<br><a class='btn btn-xs btn-danger grid-row-pay' data-id='{$this->id}'>确认付款</a>";
    }

    public function __toString()
    {
        return $this->render();
    }
}