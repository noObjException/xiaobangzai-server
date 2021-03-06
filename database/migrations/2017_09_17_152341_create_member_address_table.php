<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMemberAddressTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('member_address', function (Blueprint $table) {
            $table->increments('id');
            $table->string('realname');
            $table->integer('user_id')->index();
            $table->string('mobile');
            $table->integer('college_id');
            $table->integer('area_id');
            $table->string('detail')->nullable();
            $table->tinyInteger('is_default');
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
        Schema::dropIfExists('member_address');
    }
}
