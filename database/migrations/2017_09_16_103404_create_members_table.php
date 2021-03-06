<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('members', function (Blueprint $table) {
            $table->increments('id');

            $table->string('openid')->nullable()->index();
            $table->string('wx_mini_openid')->nullable()->index()->commit('微信小程序openid');
            $table->string('wx_union_id')->nullable()->index()->commit('微信unionid');
            $table->string('realname')->nullable();
            $table->string('nickname')->nullable();
            $table->string('mobile')->nullable();
            $table->integer('point')->default('0');
            $table->decimal('balance')->default('0.00');
            $table->tinyInteger('status')->default('1');
            $table->tinyInteger('gender')->nullable();
            $table->string('avatar')->nullable();
            $table->string('province')->nullable();
            $table->string('city')->nullable();
            $table->string('area')->nullable();
            $table->integer('group_id');
            $table->integer('level_id');
            $table->tinyInteger('is_follow')->default('1');
            $table->tinyInteger('is_staff')->default('0')->commit('是否是配送员');
            $table->tinyInteger('is_identify')->default('0')->commit('是否是认证用户');
            $table->string('follow_channel')->nullable()->commit('关注途径');

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
        Schema::dropIfExists('members');
    }
}
