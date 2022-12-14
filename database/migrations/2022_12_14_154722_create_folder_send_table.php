<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFolderSendTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('folder_send', function (Blueprint $table) {
            $table->unsignedBigInteger('folder_id');
            $table->unsignedBigInteger('send_id');
            $table->timestamps();
            $table->primary(['folder_id', 'send_id']);
            $table->foreign('folder_id')->references('id')->on('folders')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreign('send_id')->references('id')->on('sends')->cascadeOnUpdate()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('folder_send');
    }
}
