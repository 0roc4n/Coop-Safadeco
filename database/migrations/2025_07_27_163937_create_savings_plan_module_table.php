<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('savingsplan', function (Blueprint $table) {
            $table->id('SavID');
            $table->string('PlanName', 50);
            $table->string('AcctCode', 12);
            $table->string('Remark', 50);
            $table->timestamps();
            $table->foreign('AcctCode')->references('AcctCode')->on('acct_codes')->onDelete('cascade');
        });

        Schema::create('savingsplanammort', function (Blueprint $table) {
            $table->id('SavAmID');
            $table->unsignedBigInteger('ClSavID');
            $table->dateTime('DueDate')->nullable();
            $table->decimal('Principal', 19, 4)->nullable();
            $table->decimal('PrinBal', 19, 4)->nullable();
            $table->decimal('AmountPaid', 19, 4)->nullable();
            $table->decimal('PaidBal', 19, 4)->nullable();
            $table->dateTime('DatePaid')->nullable();
            $table->timestamps();

            $table->foreign('ClSavID')->references('SavID')->on('savingsplan');
        });

        Schema::create('savingsplaninterest', function (Blueprint $table) {
            $table->id('SavPlanIntID');
            $table->dateTime('PostDate');
            $table->decimal('Amount', 19, 4);
            $table->dateTime('PostedDate')->nullable();
            $table->string('Transcode', 15)->nullable();
            $table->boolean('IsPosted')->nullable();
            $table->string('UserID', 16)->nullable();
            $table->unsignedBigInteger('ClSavID')->nullable();
            $table->integer('numDays')->nullable();
            $table->decimal('SPBal', 19, 4)->nullable();
            $table->boolean('IsExtend')->nullable();
            $table->timestamps();
            $table->foreign('ClSavID')->references('SavID')->on('savingsplan');
        });

        Schema::create('savingsplanpayment', function (Blueprint $table) {
            $table->id('SavPymtID');
            $table->unsignedBigInteger('ClSavID');
            $table->decimal('Amount', 19, 4)->nullable();
            $table->dateTime('PaymentDate')->nullable();
            $table->string('TransCode', 15);
            $table->string('Remarks', 50)->nullable();
            $table->integer('FolderKey')->nullable();
            $table->decimal('surcharge', 19, 4)->nullable();
            $table->decimal('reinstatementfee', 19, 4)->nullable();
            $table->tinyInteger('iswaive')->default(0)->nullable();
            $table->timestamps();
            $table->foreign('ClSavID')->references('SavID')->on('savingsplan');
        });

        Schema::create('savingsplanpolicypenalty', function (Blueprint $table) {
            $table->id('PolPenID');
            $table->string('Description', 50)->nullable();
            $table->timestamps();
        });

        Schema::create('savingsplanpenalty', function (Blueprint $table) {
            $table->id('SavPenID');
            $table->decimal('Fee', 19, 4)->nullable();
            $table->float('Surcharge')->nullable();
            $table->integer('LapseTerm')->nullable();
            $table->integer('LapseFreq')->nullable();
            $table->integer('GraceTerm')->nullable();
            $table->integer('GraceFreq')->nullable();
            $table->dateTime('EffectivityDate')->nullable();
            $table->unsignedBigInteger('PolPenID');
            $table->timestamps();
            $table->foreign('PolPenID')->references('PolPenID')->on('savingsplanpolicypenalty');
        });

        Schema::create('savingsplanpolicy', function (Blueprint $table) {
            $table->id('PolicyID');
            $table->string('Title', 50)->nullable();
            $table->decimal('GrossValue', 19, 4)->nullable();
            $table->integer('Frequency')->nullable();
            $table->integer('PolicyTerm')->nullable();
            $table->float('PolicyRate')->nullable();
            $table->dateTime('EffectivityDate')->nullable();
            $table->float('RegularRate')->nullable();
            $table->integer('ExtendedTerm')->nullable();
            $table->float('ExtendedRate')->nullable();
            $table->unsignedBigInteger('SavID');
            $table->unsignedBigInteger('PolPenID')->nullable();
            $table->integer('MOP')->nullable();
            $table->integer('intMOP')->nullable();
            $table->decimal('MinDep', 19, 4)->nullable();
            $table->decimal('FilingFee', 19, 4)->nullable();
            $table->decimal('ShareCapital', 19, 4)->nullable();
            $table->decimal('SubFee', 19, 4)->nullable();
            $table->timestamps();
            $table->foreign('SavID')->references('SavID')->on('savingsplan');
            $table->foreign('PolPenID')->references('PolPenID')->on('savingsplanpolicypenalty');
        });

        Schema::create('savingsplanpost', function (Blueprint $table) {
            $table->id('SPPostID');
            $table->unsignedBigInteger('ClSavID')->nullable();
            $table->decimal('Amount', 19, 4)->nullable();
            $table->dateTime('PostDate')->nullable();
            $table->boolean('isExtend')->nullable();
            $table->boolean('isBegRateBal')->nullable();
            $table->string('Transcode', 15)->nullable();
            $table->timestamps();
            $table->foreign('ClSavID')->references('SavID')->on('savingsplan');
        });

        Schema::create('savingspostinglog', function (Blueprint $table) {
            $table->id('PostingID');
            $table->unsignedBigInteger('FolderKey');
            $table->dateTime('PostingDate');
            $table->string('AcctCode', 12);
            $table->smallInteger('PostingType');
            $table->smallInteger('PeriodType');
            $table->string('TransCode', 15)->nullable();
            $table->timestamps();
            $table->foreign('AcctCode')->references('AcctCode')->on('acct_codes')->onDelete('cascade');
            // $table->foreign('TransCode')->references('TransCode')->on('trans_codes')->onDelete('cascade');
            $table->foreign('FolderKey')->references('FolderKey')->on('books')->onDelete('cascade');
        });
    }

    public function down(): void {
        Schema::dropIfExists('savingspostinglog');
        Schema::dropIfExists('savingsplanpost');
        Schema::dropIfExists('savingsplanpolicy');
        Schema::dropIfExists('savingsplanpenalty');
        Schema::dropIfExists('savingsplanpolicypenalty');
        Schema::dropIfExists('savingsplanpayment');
        Schema::dropIfExists('savingsplaninterest');
        Schema::dropIfExists('savingsplanammort');
        Schema::dropIfExists('savingsplan');
    }
};
