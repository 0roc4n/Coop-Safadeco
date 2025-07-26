<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // lpymtdetails table
        Schema::create('lpymtdetails', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('LoanPymtKey')->nullable();
            $table->string('AcctCode', 12)->nullable();
            $table->decimal('Amount', 19, 4)->default(0.0000);
            $table->string('CheckNo', 16)->nullable();
            $table->decimal('PrincipalAmt', 19, 4)->default(0.0000);
            $table->decimal('InterestAmt', 19, 4)->default(0.0000);
            $table->decimal('FSav1Amt', 19, 4)->default(0.0000);
            $table->decimal('FSav2Amt', 19, 4)->default(0.0000);
            $table->decimal('FSav3Amt', 19, 4)->default(0.0000);
            $table->decimal('FSav4Amt', 19, 4)->default(0.0000);
            $table->decimal('FSav5Amt', 19, 4)->default(0.0000);
            $table->decimal('PenaltyAmt', 19, 4)->default(0.0000);
            $table->integer('PymtType')->default(0)->nullable();
            $table->char('OthPymt', 1)->nullable();
            $table->decimal('BMaintainAmt', 19, 4)->default(0.0000);
            $table->decimal('DormantAmt', 19, 4)->default(0.0000);
            $table->tinyInteger('LnPrnYN')->default(0)->nullable();
            $table->integer('LnLine')->default(0)->nullable();
            $table->integer('LnPage')->default(0)->nullable();
            $table->integer('LnBook')->default(0)->nullable();
            $table->string('CLKey')->default(0)->nullable();
            $table->string('ClientCode')->default('')->nullable();
            $table->decimal('RebateAmt', 19, 4)->default(0.0000);
            $table->decimal('IntAftrMat', 19, 4)->default(0.0000);
            $table->decimal('PenaltyAftMat', 19, 4)->nullable();
            $table->timestamps();
            $table->foreign('LoanPymtKey')->references('LoanPymtKey')->on('loan_pymt_d_t_l_s')->onDelete('cascade');
            $table->foreign('AcctCode')->references('AcctCode')->on('acct_codes')->onDelete('cascade');
            $table->foreign('ClientCode')->references('ClientCode')->on('clienteles')->onDelete('cascade');
            $table->foreign('CLKey')->references('CLKey')->on('client_loans')->onDelete('cascade');
        });

        // ltpdetails table
        Schema::create('ltpdetails', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('LoanPymtKey');
            $table->string('CLKey');
            $table->dateTime('DateDue');
            $table->decimal('PrinAmtPaid', 19, 4)->default(0.0000)->nullable();
            $table->decimal('IntAmtPaid', 19, 4)->default(0.0000)->nullable();
            $table->decimal('FSav1', 19, 4)->nullable();
            $table->decimal('FSav2', 19, 4)->nullable();
            $table->decimal('FSav3', 19, 4)->nullable();
            $table->decimal('FSav4', 19, 4)->nullable();
            $table->decimal('FSav5', 19, 4)->nullable();
            $table->timestamps();
            $table->foreign('LoanPymtKey')->references('LoanPymtKey')->on('loan_pymt_d_t_l_s')->onDelete('cascade');
            $table->foreign('CLKey')->references('CLKey')->on('client_loans')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ltpdetails');
        Schema::dropIfExists('lpymtdetails');
    }
};
