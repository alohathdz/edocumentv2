<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFolderPresentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('folder_present', function (Blueprint $table) {
            $table->unsignedBigInteger('folder_id');
            $table->unsignedBigInteger('present_id');
            $table->timestamps();
            $table->primary(['folder_id', 'present_id']);
            $table->foreign('folder_id')->references('id')->on('folders')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreign('present_id')->references('id')->on('presents')->cascadeOnUpdate()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('folder_present');
    }
}
