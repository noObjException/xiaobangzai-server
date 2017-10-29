<?php
namespace App\Api\V1\Controllers\Wechat;


use App\Api\BaseController;
use App\Services\Wechat;

class PaymentController extends BaseController
{
    public function wxPay()
    {
        $payment = Wechat::app()->payment;


    }
}