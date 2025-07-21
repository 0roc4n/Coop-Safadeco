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
        Schema::create('client_loans', function (Blueprint $table) {
            $table->increments('CLKey');
            $table->integer('LACode');
            $table->string('AcctCode', 12);
            $table->string('ClientCode', 10);
            $table->decimal('Amount', 18, 4);
            $table->decimal('UnearnedInterest', 18, 4);
            $table->decimal('InterestEarned', 18, 4);
            $table->dateTime('DateReleased')->nullable();
            $table->dateTime('EndDate')->nullable();
            $table->decimal('Balance', 18, 4);
            $table->tinyInteger('LoanPaid');
            $table->string('Remarks', 100)->nullable();
            $table->unsignedInteger('FolderKey');;
            $table->tinyInteger('LoanType');
            $table->tinyInteger('LoanTrans');
            $table->integer('AmortTerm')->nullable();
            $table->smallInteger('AmortType')->nullable();
            $table->smallInteger('PrinMOP')->nullable();
            $table->smallInteger('MOP')->nullable();
            $table->decimal('MonthlyPymt', 18, 4);
            $table->integer('PymtCounter');
            $table->decimal('Rate', 18, 4);
            $table->decimal('Interest', 18, 4);
            $table->dateTime('OrigPymtDate')->nullable();
            $table->decimal('PrinBal', 18, 4);
            $table->decimal('IntBal', 18, 4);
            $table->decimal('PrincipalPaid', 18, 4);
            $table->decimal('InterestPaid', 18, 4);
            $table->decimal('PenaltyBal', 18, 4);
            $table->decimal('PenaltyPaid', 18, 4);
            $table->decimal('PrincipalDue', 18, 4);
            $table->decimal('InterestDue', 18, 4);
            $table->decimal('FSav1Bal', 18, 4);
            $table->decimal('FSav1Paid', 18, 4);
            $table->decimal('FSav1Due', 18, 4);
            $table->decimal('FSav2Bal', 18, 4);
            $table->decimal('FSav2Paid', 18, 4);
            $table->decimal('FSav2Due', 18, 4);
            $table->decimal('FSav3Bal', 18, 4);
            $table->decimal('FSav3Paid', 18, 4);
            $table->decimal('FSav3Due', 18, 4);
            $table->decimal('FSav4Bal', 18, 4);
            $table->decimal('FSav4Paid', 18, 4);
            $table->decimal('FSav4Due', 18, 4);
            $table->decimal('FSav5Bal', 18, 4);
            $table->decimal('FSav5Paid', 18, 4);
            $table->decimal('FSav5Due', 18, 4);
            $table->integer('TermQty')->nullable();
            $table->smallInteger('TermTime')->nullable();
            $table->decimal('Principal_Amortized', 18, 4);
            $table->decimal('Interest_Amortized', 18, 4);
            $table->tinyInteger('AmortTypeCD');
            $table->string('TransCode', 15)->nullable();
            $table->string('TransCodeJV', 15)->nullable();
            $table->decimal('PrincipalCap', 18, 4)->nullable();
            $table->decimal('PenaltyCap', 18, 4)->nullable();
            $table->string('Collateral', 500)->nullable();
            $table->string('CoMaker', 500)->nullable();
            $table->unsignedInteger('RestructuredFrom')->nullable();
            $table->unsignedInteger('RestructuredTo')->nullable();
            $table->decimal('RebateAmount', 18, 4);
            $table->string('CloseTranCode', 15)->nullable();
            $table->dateTime('ClosedDate')->nullable();
            $table->string('CreatedBy', 16)->nullable();
            $table->dateTime('DateCreated')->nullable();
            $table->string('UpdatedBy', 16)->nullable();
            $table->dateTime('DateUpdated')->nullable();
            $table->timestamps();

            $table->foreign('ClientCode')->references('ClientCode')->on('clienteles')->onDelete('cascade');
            $table->foreign('AcctCode')->references('AcctCode')->on('chart_of_accounts')->onDelete('restrict'); // restrict to prevent deletion of account if loans exist
            $table->foreign('FolderKey')->references('FolderKey')->on('books')->onDelete('restrict'); // restrict to prevent deletion of book/period if loans exist
            $table->foreign('TransCode')->references('BussOpCode')->on('bussoperations')->onDelete('set null');
            $table->foreign('TransCodeJV')->references('BussOpCode')->on('bussoperations')->onDelete('set null');

            $table->foreign('RestructuredFrom')->references('CLKey')->on('client_loans')->onDelete('set null');
            $table->foreign('RestructuredTo')->references('CLKey')->on('client_loans')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('client_loans');
    }
};
