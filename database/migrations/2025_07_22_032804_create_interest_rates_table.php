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
        Schema::create('interest_rates', function (Blueprint $table) {
            $table->id('RateID');
            $table->decimal('From', 19, 4);
            $table->decimal('To', 19, 4);
            $table->float('iRate');
            $table->string('AcctCode', 12);
            $table->unsignedBigInteger('IntEffDateID');
            $table->float('withTax');

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
        Schema::dropIfExists('interest_rates');
    }
};
