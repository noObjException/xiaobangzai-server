<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMemberIdentifiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('member_identifies', function (Blueprint $table) {
            $table->increments('id');
            $table->string('openid')->index();
            $table->string('username')->comment('用户名');
            $table->string('school')->comment('学校');
            $table->string('college')->comment('学院');
            $table->string('study_no')->comment('学号');
            $table->json('pictures')->comment('证件照');
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
        Schema::dropIfExists('member_identifies');
    }
}
