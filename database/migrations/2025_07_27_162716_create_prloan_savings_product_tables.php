<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Table: prothercollectibles
        Schema::create('prothercollectibles', function (Blueprint $table) {
            $table->id('ID');
            $table->string('CollectibleCode', 5);
            $table->string('Description', 30);
            $table->string('Acctcode', 12);
            $table->decimal('Amount', 19, 4);
            $table->timestamps();
            $table->foreign('Acctcode')->references('AcctCode')->on('acct_codes')->onDelete('cascade');
        });

        // Table: prsavings
        Schema::create('prsavings', function (Blueprint $table) {
            $table->id('ID');
            $table->string('AcctCode', 12);
            $table->string('SvDesc', 64)->nullable();
            $table->smallInteger('SvType')->nullable();
            $table->smallInteger('PymtMode')->nullable();
            $table->smallInteger('PymtType')->nullable();
            $table->decimal('PymtVal', 19, 4)->nullable();
            $table->float('IRate');
            $table->string('UserRefCd', 6);
            $table->tinyInteger('Collect_Yn')->default(0)->nullable();
            $table->integer('CollPymt')->nullable();
            $table->decimal('CollAmt', 19, 4)->nullable();
            $table->decimal('MaintainBalance', 19, 4)->default(0)->nullable();
            $table->tinyInteger('Withdrawable')->default(0)->nullable();
            $table->integer('DMonth')->default(0)->nullable();
            $table->decimal('ChargeAmt', 19, 4)->default(0)->nullable();
            $table->decimal('DChargeAmt', 19, 4)->default(0)->nullable();
            $table->integer('UpfrontBasis')->default(0)->nullable();
            $table->string('IntExpenseAcct', 15)->nullable();
            $table->boolean('isSpecialSavings')->nullable();
            $table->float('sRate')->nullable();
            $table->timestamps();
            $table->foreign('AcctCode')->references('AcctCode')->on('acct_codes')->onDelete('cascade');
        });

        // Table: prtimedeposits
        Schema::create('prtimedeposits', function (Blueprint $table) {
            $table->id();
            $table->string('AcctCode', 15);
            $table->string('Description', 64);
            $table->integer('AccruedInterest');
            $table->integer('nonWorkingDays');
            $table->decimal('TimeDepInt', 19, 4);
            $table->string('TimeDepIntAcct', 15);
            $table->string('AccruedIntAcct', 15)->nullable();
            $table->decimal('WTaxInt', 19, 4)->default(0)->nullable();
            $table->string('WTaxAcct', 15)->nullable();
            $table->string('AccruedWTaxAcct', 15)->nullable();
            $table->decimal('WithholdingTax', 19, 4)->default(0)->nullable();
            $table->timestamps();
            $table->foreign('AcctCode')->references('AcctCode')->on('acct_codes')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('prtimedeposits');
        Schema::dropIfExists('prsavings');
        Schema::dropIfExists('prothercollectibles');
    }
};
