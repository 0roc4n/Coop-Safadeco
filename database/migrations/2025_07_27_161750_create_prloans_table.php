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
        Schema::create('prloans', function (Blueprint $table) {
            $table->id('ID');
            $table->string('AcctCode', 12);
            $table->string('LnDesc', 64)->nullable();
            $table->smallInteger('LendMeth')->nullable();
            $table->smallInteger('PrinMOP')->nullable();
            $table->float('IRate')->nullable();
            $table->smallInteger('IntMOP')->nullable();
            $table->smallInteger('IntComp')->nullable();
            $table->smallInteger('TermQty')->nullable();
            $table->integer('TermTime')->nullable();
            $table->integer('MOP')->nullable();
            $table->string('FunderCode', 10)->nullable();
            $table->integer('TermRes')->nullable();
            $table->float('RtPassScore')->nullable();
            $table->string('UserRefCd', 6);
            $table->string('FSav1', 10)->nullable();
            $table->string('FSav2', 10)->nullable();
            $table->string('FSav3', 10)->nullable();
            $table->string('FSav4', 10)->nullable();
            $table->string('FSav5', 10)->nullable();
            $table->smallInteger('SChargeType')->nullable();
            $table->decimal('SChargeAmt', 19, 4)->nullable();
            $table->string('InterestAcct', 10)->nullable();
            $table->integer('GracePeriod')->default(0)->nullable();

            for ($i = 1; $i <= 5; $i++) {
                $table->smallInteger("PymtTypeSav$i")->nullable();
                $table->decimal("PymtAmtSav$i", 19, 4)->nullable();
                $table->smallInteger("PymtMode$i")->nullable();
                $table->tinyInteger("AllocTypeSav$i")->default(1)->nullable();
            }

            $table->tinyInteger('IntAfterMaturity_YN')->default(0)->nullable();
            $table->decimal('MaturityIntRate', 19, 4)->default(0)->nullable();
            $table->tinyInteger('IncIntLOBal_YN')->default(0)->nullable();
            $table->integer('MaturityIntType')->default(0)->nullable();
            for ($i = 1; $i <= 5; $i++) {
                $table->integer("UpfrontBasis$i")->default(0)->nullable();
            }

            $table->integer('AccrualType')->default(0)->nullable();
            $table->integer('EColChargePenalty')->default(0)->nullable();
            $table->integer('EColPenaltyType')->default(-1)->nullable();
            $table->decimal('EColPenaltyRate', 19, 4)->default(0)->nullable();
            $table->integer('EColPenaltyBasis')->default(-1)->nullable();
            $table->integer('EColPenaltyFreq')->default(-1)->nullable();
            $table->integer('EColIncInterest')->default(0)->nullable();
            $table->integer('AfMatChargePenalty')->default(0)->nullable();
            $table->integer('AfMatPenaltyType')->default(-1)->nullable();
            $table->decimal('AfMatPenaltyRate', 19, 4)->default(0)->nullable();
            $table->integer('AfMatPenaltyBasis')->default(-1)->nullable();
            $table->integer('AfMatPenaltyFreq')->default(-1)->nullable();
            $table->integer('AfMatIncInterest')->default(0)->nullable();

            $table->tinyInteger('allowmultiple')->default(0)->nullable();
            $table->tinyInteger('ApplyInterestToFld')->default(1)->nullable();
            $table->tinyInteger('IsAddInterest')->default(1)->nullable();
            $table->tinyInteger('IsAutoOR')->default(1)->nullable();
            $table->integer('PenaltyRateBasis')->default(0)->nullable();
            $table->timestamps();
            $table->foreign('AcctCode')->references('AcctCode')->on('acct_codes')->onDelete('cascade');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prloans');
    }
};
