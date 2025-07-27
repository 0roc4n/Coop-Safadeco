<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('statementofdivandpat', function (Blueprint $table) {
            $table->id('AutoID');
            $table->decimal('AmountAllocated', 19, 4)->nullable();
            $table->decimal('TotalAverageShare', 19, 4)->nullable();
            $table->integer('CutOff')->nullable();
            $table->dateTime('StartDate')->nullable();
            $table->dateTime('EndDate')->nullable();
            $table->string('TransDiv', 15)->nullable();
            $table->string('AcctCode', 12)->nullable();
            $table->timestamps();
            $table->foreign('AcctCode')->references('AcctCode')->on('acct_codes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('statementofdivandpat');
    }
};
