<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePresentUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('present_user', function (Blueprint $table) {
            $table->unsignedBigInteger('present_id');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();
            $table->primary(['present_id', 'user_id']);
            $table->foreign('present_id')->references('id')->on('presents')->cascadeOnUpdate()->cascadeOnDelete();
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
        Schema::dropIfExists('present_user');
    }
}
