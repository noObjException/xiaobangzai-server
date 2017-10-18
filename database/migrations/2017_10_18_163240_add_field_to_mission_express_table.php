<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldToMissionExpressTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mission_express', function (Blueprint $table) {
            $table->json('deductible_fees')->nullable()->comment('抵扣部分, 如: 积分,余额,优惠券等');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mission_express', function (Blueprint $table) {
            //
        });
    }
}
