<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKeepReceivesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('keep_receives', function (Blueprint $table) {
            $table->unsignedBigInteger('receive_id');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();
            $table->primary(['receive_id', 'user_id']);
            $table->foreign('receive_id')->references('id')->on('receives')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnUpdate()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('keep_receives');
    }
}
