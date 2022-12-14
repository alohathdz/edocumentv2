<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFolderCommandTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('folder_command', function (Blueprint $table) {
            $table->unsignedBigInteger('folder_id');
            $table->unsignedBigInteger('command_id');
            $table->timestamps();
            $table->primary(['folder_id', 'command_id']);
            $table->foreign('folder_id')->references('id')->on('folders')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreign('command_id')->references('id')->on('commands')->cascadeOnUpdate()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('folder_command');
    }
}
