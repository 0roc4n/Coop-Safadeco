<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('prloaneligibility', function (Blueprint $table) {
            $table->id('ID');
            $table->string('AcctCode', 12);
            $table->decimal('MinShareCapital', 19, 4);
            $table->decimal('MaxShareCapital', 19, 4);
            $table->integer('Employment');
            $table->integer('Membership');
            $table->decimal('LoanPayment', 19, 4);
            $table->char('LoanPaymentType', 1);
            $table->char('RequireCoMaker', 1);
            $table->integer('TotalCoMakers');
            $table->integer('CoMakerReq');
            $table->decimal('FixedDeposits', 19, 4);
            $table->integer('MaxYear');
            $table->timestamps();
            $table->foreign('AcctCode')->references('AcctCode')->on('acct_codes')->onDelete('cascade');
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prloaneligibilities');
    }
};
