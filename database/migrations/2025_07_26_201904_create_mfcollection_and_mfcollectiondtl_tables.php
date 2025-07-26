<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMfcollectionAndMfcollectiondtlTables extends Migration
{
    public function up()
    {
        Schema::create('mfcollection', function (Blueprint $table) {
            $table->integer('MFCollectionID')->primary();
            $table->string('ClientCode', 10);
            $table->string('TransCode', 15);
            $table->dateTime('BalanceDate');
            $table->decimal('TotalAmount', 19, 4);
            $table->timestamps();
            $table->foreign('ClientCode')->references('ClientCode')->on('clienteles')->onDelete('cascade');
            // $table->foreign('TransCode')->references('TransCode')->on('trans_codes')->onDelete('cascade');
        });

        Schema::create('mfcollectiondtl', function (Blueprint $table) {
            $table->integer('MFCollectionDtlID')->primary();
            $table->integer('MFCollectionID');
            $table->string('ClientCode', 10);
            $table->decimal('Balance', 19, 4);
            $table->decimal('Amount', 19, 4);
            $table->timestamps();
            $table->foreign('MFCollectionID')->references('MFCollectionID')->on('mfcollection')->onDelete('cascade');
            $table->foreign('ClientCode')->references('ClientCode')->on('clienteles')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('mfcollectiondtl');
        Schema::dropIfExists('mfcollection');
    }
}
