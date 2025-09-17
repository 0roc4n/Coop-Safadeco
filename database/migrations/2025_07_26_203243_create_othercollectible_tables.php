<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOthercollectibleTables extends Migration
{
    public function up()
    {
        Schema::create('othercollectible', function (Blueprint $table) {
            $table->id('CollectibleID');
            $table->dateTime('CollectionDate');
            $table->string('CollectibleCode', 5);
            $table->timestamps();
        });

        Schema::create('othercollectibledtl', function (Blueprint $table) {
            $table->id('CollectibleID');
            $table->string('ClientCode', 10);
            $table->decimal('Collectible', 19, 4);
            $table->decimal('Collected', 19, 4);
            $table->string('TransCode', 15);
            $table->timestamps();
            // $table->foreign('CollectibleID')->references('CollectibleID')->on('othercollectible')->onDelete('cascade');
            $table->foreign('ClientCode')->references('ClientCode')->on('clienteles')->onDelete('cascade');
            // $table->foreign('TransCode')->references('TransCode')->on('trans_codes')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('othercollectibledtl');
        Schema::dropIfExists('othercollectible');
    }
}
