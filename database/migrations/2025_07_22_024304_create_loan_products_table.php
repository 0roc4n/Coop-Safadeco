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
        Schema::create('loan_products', function (Blueprint $table) {
            $table->string('LoanCode', 12)->primary();
            $table->smallInteger('LoanType');
            $table->string('Description', 64);
            $table->float('IRate');
            $table->string('FSav1', 12)->nullable();
            $table->string('FSav2', 12)->nullable();
            $table->string('FSav3', 12)->nullable();
            $table->string('FSav4', 12)->nullable();
            $table->string('FSav5', 12)->nullable();
            $table->smallInteger('FSav1Type');
            $table->smallInteger('FSav2Type');
            $table->smallInteger('FSav3Type');
            $table->smallInteger('FSav4Type');
            $table->smallInteger('FSav5Type');
            $table->decimal('InterestRate', 19, 4);
            $table->integer('Compounding');
            $table->decimal('LoanAmount', 19, 4);
            $table->integer('PrincipalMOP');
            $table->integer('InterestMOP');
            $table->integer('LoanTerm');
            $table->integer('TermQty');
            $table->integer('GracePeriod');
            $table->decimal('PenaltyRate', 19, 4);
            $table->integer('PenaltyComp');
            $table->decimal('ServCharge', 19, 4);
            $table->integer('ServChargeType');
            $table->decimal('DocStamp', 19, 4);
            $table->integer('DocStampType');
            $table->decimal('MRI', 19, 4);
            $table->integer('MRIType');
            $table->decimal('NotarialFee', 19, 4);
            $table->integer('NotarialFeeType');
            $table->decimal('FilingFee', 19, 4);
            $table->integer('FilingFeeType');
            $table->decimal('CIBI', 19, 4);
            $table->integer('CIBIType');
            $table->decimal('AFees', 19, 4);
            $table->integer('AFeesType');
            $table->decimal('CBAmount', 19, 4);
            $table->integer('CBType');
            $table->integer('PenaltyGracePeriod');
            $table->decimal('MinLoanAmount', 19, 4);
            $table->decimal('MaxLoanAmount', 19, 4);
            $table->integer('MaxTerm');
            $table->integer('MinTerm');
            $table->boolean('HasCollateral');
            $table->boolean('HasCoMaker');
            $table->integer('PrinUseMode');
            $table->integer('IntUseMode');
            $table->integer('SavingsUseMode');
            $table->tinyInteger('LoanProdGroup');
            $table->boolean('FixedRate');
            $table->float('MinInterestRate')->nullable();
            $table->float('MaxInterestRate')->nullable();
            $table->boolean('AutoPenalty')->nullable();
            $table->boolean('LoanTerminMaturity')->nullable();
            $table->decimal('PenaltyComputedPer', 19, 4)->nullable();
            $table->string('PenaltyGL', 12)->nullable();
            $table->string('AcctCode_Penalty', 12)->nullable();
            $table->string('AcctCode_ServiceCharge', 12)->nullable();
            $table->string('AcctCode_DocumentStamp', 12)->nullable();
            $table->string('AcctCode_MRI', 12)->nullable();
            $table->string('AcctCode_NotarialFee', 12)->nullable();
            $table->string('AcctCode_FilingFee', 12)->nullable();
            $table->string('AcctCode_CIBI', 12)->nullable();
            $table->string('AcctCode_AFees', 12)->nullable();
            $table->string('AcctCode_CB', 12)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loan_products');
    }
};
