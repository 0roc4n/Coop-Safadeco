<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBillingTables extends Migration
{
    public function up()
    {
        Schema::create('billingstatementhdr', function (Blueprint $table) {
            $table->id('BillingHdrID');
            $table->dateTime('BillingDate');
            $table->string('DocumentNo', 15)->nullable();
            $table->string('Remarks', 120)->nullable();
            $table->dateTime('PymtDate')->nullable();
            $table->dateTime('DateGenerated');
            $table->string('TransCode', 20)->nullable();
        });

        Schema::create('billingstatement', function (Blueprint $table) {
            $table->id('BillID');
            $table->string('AcctCode', 15);
            $table->string('ClientCode', 15);
            $table->decimal('AmtDue', 19, 4)->nullable();
            $table->decimal('AmtPaid', 19, 4)->nullable();
            $table->unsignedBigInteger('BillHdrID');
            $table->string('BillType', 3);
            $table->string('TransCode', 20)->nullable();

            $table->foreign('BillHdrID')
                  ->references('BillingHdrID')
                  ->on('billingstatementhdr')
                  ->onDelete('cascade');
        });

        Schema::create('billingloans', function (Blueprint $table) {
            $table->id('BillLoanID');
            $table->unsignedBigInteger('CLKey');
            $table->string('LoanPymtType', 3);
            $table->unsignedBigInteger('BillID');

            $table->foreign('BillID')
                  ->references('BillID')
                  ->on('billingstatement')
                  ->onDelete('cascade');
        });

        Schema::create('billingsavings', function (Blueprint $table) {
            $table->id('BillSavingsID');
            $table->unsignedBigInteger('CSHDRKey');
            $table->unsignedBigInteger('BillID');

            $table->foreign('BillID')
                  ->references('BillID')
                  ->on('billingstatement')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('billingsavings');
        Schema::dropIfExists('billingloans');
        Schema::dropIfExists('billingstatement');
        Schema::dropIfExists('billingstatementhdr');
    }
}
