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
        Schema::create('loans__temps', function (Blueprint $table) {
            $table->id();
            $table->string('CLKey', 10); 
            $table->unsignedBigInteger('LACode');
            $table->string('ClientCode', 10);
            $table->string('CenterGrpKey', 20)->nullable();
            $table->string('AcctCode', 12);
            $table->decimal('Amount', 19, 4);
            $table->dateTime('DateReleased')->nullable();
            $table->string('CheckNum', 12)->nullable();
            $table->string('TransCode', 15)->nullable();
            $table->dateTime('BegDate')->nullable();
            $table->string('Collateral', 40)->nullable();
            $table->decimal('Col_Value', 19, 4)->nullable();
            $table->string('CoMaker', 40)->nullable();
            $table->decimal('Principal', 19, 4);
            $table->decimal('Interest', 19, 4);
            $table->decimal('ServCharge', 19, 4);
            $table->decimal('NetProc', 19, 4);
            $table->dateTime('EndDate')->nullable();
            $table->smallInteger('LoanPaid');
            $table->string('FSav1', 12)->nullable();
            $table->string('FSav2', 12)->nullable();
            $table->string('FSav3', 12)->nullable();
            $table->string('FSav4', 12)->nullable();
            $table->string('FSav5', 12)->nullable();
            $table->decimal('LoanBalance', 19, 4)->nullable();
            $table->dateTime('StartSched')->nullable();
            $table->string('FunderCode', 10)->nullable();
            $table->string('PrgCode', 10)->nullable();
            $table->string('LocCode', 10)->nullable();
            $table->string('FCOCode', 10)->nullable();
            $table->decimal('GracePeriod', 19, 4);
            $table->integer('GracePrd')->nullable();
            $table->smallInteger('PrinMOP')->nullable();
            $table->smallInteger('TermQty')->nullable();
            $table->integer('TermTime')->nullable();
            $table->integer('MOP')->nullable();
            $table->float('IRate')->nullable();
            $table->smallInteger('IntMOP')->nullable();
            $table->smallInteger('IntComp')->nullable();
            $table->integer('TermRes')->nullable();
            $table->decimal('PrinBal', 19, 4)->nullable();
            $table->decimal('IntBal', 19, 4)->nullable();
            $table->decimal('SavBal', 19, 4)->nullable();
            $table->string('TransCodeOR', 15)->nullable();
            $table->string('TransCodeJV', 15)->nullable();
            $table->dateTime('ClosedDate')->nullable();
            $table->unsignedBigInteger('RestructuredFrom')->nullable();
            $table->smallInteger('PymtTypeSav1')->nullable();
            $table->smallInteger('PymtTypeSav2')->nullable();
            $table->smallInteger('PymtTypeSav3')->nullable();
            $table->smallInteger('PymtTypeSav4')->nullable();
            $table->smallInteger('PymtTypeSav5')->nullable();
            $table->decimal('PymtAmtSav1', 19, 4)->nullable();
            $table->decimal('PymtAmtSav2', 19, 4)->nullable();
            $table->decimal('PymtAmtSav3', 19, 4)->nullable();
            $table->decimal('PymtAmtSav4', 19, 4)->nullable();
            $table->decimal('PymtAmtSav5', 19, 4)->nullable();
            $table->decimal('LoanProceeds', 19, 4)->nullable();
            $table->smallInteger('PymtMode1')->nullable();
            $table->smallInteger('PymtMode2')->nullable();
            $table->smallInteger('PymtMode3')->nullable();
            $table->smallInteger('PymtMode4')->nullable();
            $table->smallInteger('PymtMode5')->nullable();
            $table->unsignedBigInteger('LoanNumber')->nullable();

            // Foreign keys
            $table->foreign('CLKey')->references('CLKey')->on('client_loans')->onDelete('cascade');
            $table->foreign('LACode')->references('LACode')->on('loan_applications')->onDelete('cascade');
            $table->foreign('ClientCode')->references('ClientCode')->on('clienteles')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loans__temps');
    }
};
