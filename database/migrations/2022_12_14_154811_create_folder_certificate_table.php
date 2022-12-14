<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFolderCertificateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('folder_certificate', function (Blueprint $table) {
            $table->unsignedBigInteger('folder_id');
            $table->unsignedBigInteger('certificate_id');
            $table->timestamps();
            $table->primary(['folder_id', 'certificate_id']);
            $table->foreign('folder_id')->references('id')->on('folders')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreign('certificate_id')->references('id')->on('certificates')->cascadeOnUpdate()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('folder_certificate');
    }
}
