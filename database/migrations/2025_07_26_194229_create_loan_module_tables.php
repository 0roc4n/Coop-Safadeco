<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('loancertification', function (Blueprint $table) {
            $table->id();
            $table->decimal('Minimum', 19, 4)->nullable();
            $table->decimal('Maximum', 19, 4)->nullable();
            $table->string('Remarks', 200)->nullable();
            $table->integer('Active');
            $table->timestamps();
        });

        Schema::create('loanpassbook', function (Blueprint $table) {
            $table->id();
            $table->string('CLKey');
            $table->string('ClientCode', 15)->nullable();
            $table->string('AcctCode', 15)->nullable();
            $table->string('TransCode', 15);
            $table->dateTime('TransDate');
            $table->decimal('LoanAmount', 19, 4)->default(0);
            $table->decimal('PrinAmtPaid', 19, 4)->default(0);
            $table->decimal('IntAmtPaid', 19, 4);
            $table->decimal('Penalty', 19, 4)->default(0);
            $table->decimal('Balance', 19, 4)->default(0);
            $table->tinyInteger('PrintPassbook')->default(0);
            $table->tinyInteger('PrintLedger')->default(0);
            $table->char('ModuleType', 1);
            $table->integer('Line')->default(0)->nullable();
            $table->integer('Page')->default(0)->nullable();
            $table->integer('Book')->default(0)->nullable();
            $table->integer('LedgerLine')->default(0)->nullable();
            $table->integer('LedgerPage')->default(0)->nullable();
            $table->integer('LedgerBook')->default(0)->nullable();
            $table->decimal('InterestAmt', 19, 4)->default(0);
            $table->decimal('FSav1Amt', 19, 4)->default(0);
            $table->decimal('FSav2Amt', 19, 4)->default(0);
            $table->decimal('FSav3Amt', 19, 4)->default(0);
            $table->decimal('FSav4Amt', 19, 4)->default(0);
            $table->decimal('FSav5Amt', 19, 4)->default(0);
            $table->decimal('FSav1Paid', 19, 4)->default(0);
            $table->decimal('FSav2Paid', 19, 4)->default(0);
            $table->decimal('FSav3Paid', 19, 4)->default(0);
            $table->decimal('FSav4Paid', 19, 4)->default(0);
            $table->decimal('FSav5Paid', 19, 4)->default(0);
            $table->timestamps();
            $table->foreign('CLKey')->references('CLKey')->on('client_loans')->onDelete('cascade');
            $table->foreign('AcctCode')->references('AcctCode')->on('acct_codes')->onDelete('cascade');
        });

        Schema::create('loanpaymentallocation', function (Blueprint $table) {
            $table->id();
            $table->string('Payment', 50)->nullable();
            $table->string('Description', 50)->nullable();
            $table->integer('Priority')->nullable();
            $table->timestamps();
        });

        Schema::create('loanpaymentexcludetoprincipal', function (Blueprint $table) {
            $table->id();
            $table->string('clkey', 20);
            $table->string('loannumber', 20);
            $table->tinyInteger('isexcluded')->default(0)->nullable();
            $table->timestamps();
            $table->foreign('clkey')->references('CLKey')->on('client_loans')->onDelete('cascade');
        });

        Schema::create('loanproductdocumenttemplate', function (Blueprint $table) {
            $table->id();
            $table->string('ReportDir', 255);
            $table->string('ReportFile', 100);
            $table->string('AcctCode', 15);
            $table->timestamps();
            $table->foreign('AcctCode')->references('AcctCode')->on('acct_codes')->onDelete('cascade');
        });

        Schema::create('loanpurpose', function (Blueprint $table) {
            $table->id();
            $table->string('Code', 15);
            $table->string('Description', 100);
            $table->string('Remarks', 255);
            $table->timestamps();
        });

        Schema::create('loanrange', function (Blueprint $table) {
            $table->id();
            $table->string('AcctCode', 12);
            $table->decimal('From', 19, 4);
            $table->decimal('To', 19, 4);
            $table->integer('Term');
            $table->char('Frequency', 1);
            $table->float('IRate')->nullable();
            $table->timestamps();
            $table->foreign('AcctCode')->references('AcctCode')->on('acct_codes')->onDelete('cascade');
        });

        Schema::create('loantermrate', function (Blueprint $table) {
            $table->id();
            $table->string('AcctCode', 12);
            $table->decimal('From', 19, 4);
            $table->decimal('To', 19, 4);
            $table->float('IRate');
            $table->timestamps();
            $table->foreign('AcctCode')->references('AcctCode')->on('acct_codes')->onDelete('cascade');
        });

        Schema::create('loantranspymt', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('LoanPymtKey');
            $table->dateTime('PymtDate');
            $table->integer('PymtType');
            $table->string('PymtCode', 12)->nullable();
            $table->string('TransCode', 15);
            $table->string('ClientCode', 10);
            $table->decimal('Amount', 19, 4);
            $table->string('CheckNumber', 16)->nullable();
            $table->dateTime('ColDate')->nullable();
            $table->decimal('CashAmount', 19, 4)->default(0);
            $table->decimal('CheckAmount', 19, 4)->default(0);
            $table->unsignedBigInteger('FolderKey')->nullable();
            $table->char('StatusCode', 1)->default('O')->nullable();
            $table->string('Remarks', 250)->nullable();
            $table->integer('ModuleType')->default(0)->nullable();
            $table->string('DebitAcct', 15)->nullable();
            $table->string('DebitSL', 15)->nullable();
            $table->timestamps();
            $table->foreign('ClientCode')->references('ClientCode')->on('clienteles')->onDelete('cascade');
            $table->foreign('FolderKey')->references('FolderKey')->on('books')->onDelete('cascade');
            // $table->foreign('TransCode')->references('TransCode')->on('trans_codes')->onDelete('cascade');
        });

        Schema::create('loanupfrontdeductions', function (Blueprint $table) {
            $table->id();
            $table->string('LoanCode', 15)->nullable();
            $table->string('AcctCode', 15)->nullable();
            $table->integer('PymtType')->nullable();
            $table->decimal('PymtValue', 19, 4)->nullable();
            $table->boolean('ExcludeInLoanProceeds')->nullable();
            $table->integer('UpfrontBasis')->nullable();
            $table->timestamps();
            // $table->foreign('LoanCode')->references('LoanCode')->on('client_loans')->onDelete('cascade');
            $table->foreign('LoanCode')->references('LoanCode')->on('loan_products')->onDelete('cascade');
            $table->foreign('AcctCode')->references('AcctCode')->on('acct_codes')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('loanupfrontdeductions');
        Schema::dropIfExists('loantranspymt');
        Schema::dropIfExists('loantermrate');
        Schema::dropIfExists('loanrange');
        Schema::dropIfExists('loanpurpose');
        Schema::dropIfExists('loanproductdocumenttemplate');
        Schema::dropIfExists('loanpaymentexcludetoprincipal');
        Schema::dropIfExists('loanpaymentallocation');
        Schema::dropIfExists('loanpassbook');
        Schema::dropIfExists('loancertification');
    }
};
