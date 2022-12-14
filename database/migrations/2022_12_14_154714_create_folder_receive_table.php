<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFolderReceiveTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('folder_receive', function (Blueprint $table) {
            $table->unsignedBigInteger('folder_id');
            $table->unsignedBigInteger('receive_id');
            $table->timestamps();
            $table->primary(['folder_id', 'receive_id']);
            $table->foreign('folder_id')->references('id')->on('folders')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreign('receive_id')->references('id')->on('receives')->cascadeOnUpdate()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('folder_receive');
    }
}
