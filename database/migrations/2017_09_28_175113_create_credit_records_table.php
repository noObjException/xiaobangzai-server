<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePointRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('point_records', function (Blueprint $table) {
            $table->increments('id');
            $table->string('openid')->index();
            $table->string('nickname')->nullable();
            $table->string('action')->comment('操作');
            $table->integer('value')->comment('变化值');
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
        Schema::dropIfExists('point_records');
    }
}
