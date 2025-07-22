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
        Schema::create('no_of_days', function (Blueprint $table) {
            $table->id('NoOfDaysID');
            $table->integer('NoOfDays');
            $table->string('AcctCode', 12);
            $table->unsignedBigInteger('IntEffDateID');

            $table->foreign('AcctCode')->references('AcctCode')->on('acct_codes')->onDelete('cascade');
            $table->foreign('IntEffDateID')->references('IntEffDateID')->on('int_eff_dates')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('no_of_days');
    }
};
