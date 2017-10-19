<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMissionExpressTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mission_express', function (Blueprint $table) {
            $table->increments('id');

            $table->string('openid')->index();
            $table->string('order_num')->comment('订单号');
            $table->decimal('price')->comment('价格');
            $table->decimal('total_price')->comment('最后支付的总价格');
            $table->string('pay_type')->default('1')->comment('支付方式:1微信支付,2余额支付');
            $table->tinyInteger('status')->comment('状态:-1作废,0未付款,1已付款,未发货/接单,2进行中,3已完成')->index();
            $table->json('extra_costs')->comment('额外收费项')->nullable();
            $table->string('remark')->comment('备注')->nullable();
            $table->decimal('bounty')->default('0.00')->comment('追加赏金');
            $table->json('address')->comment('送货地址')->nullable();
            $table->timestamp('pay_time')->comment('支付时间')->nullable();
            $table->string('express_com')->comment('快递公司');
            $table->string('express_type')->comment('快递类型');
            $table->string('express_weight')->comment('快递重量');
            $table->string('pickup_code')->comment('取货码')->nullable();
            $table->timestamp('start_time')->comment('开始时间')->nullable();
            $table->timestamp('finish_time')->comment('完成时间')->nullable();
            $table->string('arrive_time')->comment('要求送达时间');
            $table->string('accept_order_openid')->comment('接单人openid')->nullable()->index();
            $table->json('deductible_fees')->nullable()->comment('抵扣部分, 如: 积分,余额,优惠券等');
            $table->decimal('to_staff_money')->nullable()->comment('给配送员的钱');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mission_express');
    }
}
