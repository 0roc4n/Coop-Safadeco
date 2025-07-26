<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        // Table: clpayments
        Schema::create('clpayments', function (Blueprint $table) {
            $table->id();
            $table->string('Type')->nullable()->default('');
            $table->decimal('Amount', 19, 4)->nullable()->default(0.0000);
            $table->string('TransCode')->nullable()->default('');
            $table->string('CheckNo', 12)->nullable();
            $table->timestamps();
        });

        // Table: clpenalty
        Schema::create('clpenalty', function (Blueprint $table) {
            $table->string('CLKey')->nullable()->default(0);
            $table->integer('GracePeriod')->nullable()->default(0);
            $table->integer('EColChargePenalty')->nullable()->default(-1);
            $table->integer('EColPenaltyType')->nullable()->default(-1);
            $table->decimal('EColPenaltyRate', 19, 4)->nullable()->default(-1.0000);
            $table->integer('EColPenaltyBasis')->nullable()->default(-1);
            $table->integer('EColPenaltyFreq')->nullable()->default(-1);
            $table->tinyInteger('EColIncInterest')->nullable()->default(0);
            $table->decimal('AfMatChargePenalty', 19, 4)->nullable()->default(0.0000);
            $table->integer('AfMatPenaltyType')->nullable()->default(-1);
            $table->decimal('AfMatPenaltyRate', 19, 4)->nullable()->default(0.0000);
            $table->integer('AfMatPenaltyBasis')->nullable()->default(-1);
            $table->integer('AfMatPenaltyFreq')->nullable()->default(-1);
            $table->tinyInteger('AfMatIncInterest')->nullable()->default(0);
            $table->integer('PenaltyRateBasis')->nullable()->default(0);
            $table->timestamps();
            $table->foreign('CLKey')->references('CLKey')->on('client_loans')->onDelete('cascade');
        });

        // Table: clupfrontdeductions
        Schema::create('clupfrontdeductions', function (Blueprint $table) {
            $table->string('CLKey')->nullable();
            $table->string('AcctCode', 15)->nullable();
            $table->integer('PymtType')->nullable();
            $table->decimal('PymtValue', 19, 4)->nullable();
            $table->boolean('ExcludeInLoanProceeds')->nullable();
            $table->integer('UpfrontBasis')->nullable();
            $table->timestamps();
            $table->foreign('CLKey')->references('CLKey')->on('client_loans')->onDelete('cascade');
            $table->foreign('AcctCode')->references('AcctCode')->on('acct_codes')->onDelete('cascade');
        });
    }

    public function down(): void {
        Schema::dropIfExists('clupfrontdeductions');
        Schema::dropIfExists('clpenalty');
        Schema::dropIfExists('clpayments');
    }
};
