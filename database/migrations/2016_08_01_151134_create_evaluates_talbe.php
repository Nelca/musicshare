<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEvaluatesTalbe extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('evaluates', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('evaluation');
            $table->integer('evaluatable_id');
            $table->string('evaluatable_type');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('evaluates');
    }
}
