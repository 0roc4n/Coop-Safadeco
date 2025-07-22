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
        Schema::create('int_eff_dates', function (Blueprint $table) {
            $table->id('IntEffDateID');
            $table->dateTime('Date');
            $table->string('AcctCode', 12);
            
            $table->foreign('AcctCode')->references('AcctCode')->on('acct_codes')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('int_eff_dates');
    }
};
