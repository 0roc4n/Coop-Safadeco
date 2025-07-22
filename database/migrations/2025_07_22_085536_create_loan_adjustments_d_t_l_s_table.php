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
        Schema::create('loan_adjustments_d_t_l_s', function (Blueprint $table) {
            $table->id('AdjustDTLID'); // Primary key
            $table->unsignedBigInteger('AdjustHDRID');
            $table->unsignedBigInteger('LoanPymtKey');
            $table->string('AcctCode', 12);
            $table->decimal('TotalAmt', 19, 4);
            $table->decimal('PrincipalAmt', 19, 4);
            $table->decimal('InterestAmt', 19, 4);
            $table->decimal('PenaltyAmt', 19, 4);
            $table->decimal('FSav1Amt', 19, 4);
            $table->decimal('FSav2Amt', 19, 4);
            $table->decimal('FSav3Amt', 19, 4);
            $table->decimal('FSav4Amt', 19, 4);
            $table->decimal('FSav5Amt', 19, 4);
            $table->string('CLKey');
            $table->string('TransCode', 15);
            $table->string('ClientCode', 50);
            $table->string('BalAcctCode', 12);
            $table->decimal('BalAmount', 19, 4);
            $table->string('PaymentTransCode', 15);
            $table->dateTime('PaymentDate');

            // Foreign keys
            $table->foreign('AdjustHDRID')->references('AdjustHDRID')->on('loan_adjustments_h_d_r_s')->onDelete('cascade');
            $table->foreign('LoanPymtKey')->references('LoanPymtKey')->on('loan_pymt_d_t_l_s')->onDelete('cascade');
            $table->foreign('AcctCode')->references('AcctCode')->on('acct_codes');
            // $table->foreign('BalAcctCode')->references('AcctCode')->on('acct_codes');
            $table->foreign('CLKey')->references('CLKey')->on('client_loans');
            $table->foreign('ClientCode')->references('ClientCode')->on('clienteles');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loan_adjustments_d_t_l_s');
    }
};
