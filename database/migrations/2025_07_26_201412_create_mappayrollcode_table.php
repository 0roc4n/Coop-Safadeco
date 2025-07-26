<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMappayrollcodeTable extends Migration
{
    public function up()
    {
        Schema::create('mappayrollcode', function (Blueprint $table) {
            $table->id();
            $table->integer('UploadID')->nullable();
            $table->string('AcctCode', 15)->nullable();
            $table->string('PCode', 15)->nullable();
            $table->timestamps();
            // $table->foreign('UploadID')->references('UploadID')->on('upload')->onDelete('cascade');
            $table->foreign('AcctCode')->references('AcctCode')->on('acct_codes')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('mappayrollcode');
    }
}
