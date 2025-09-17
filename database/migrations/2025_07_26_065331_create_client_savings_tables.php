<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('clientsavings', function (Blueprint $table) {
            $table->id('CSHDRKey');
            $table->string('ClientCode')->nullable();
            $table->decimal('Balance', 19, 4)->default(0);
            $table->dateTime('AppDate')->nullable();
            $table->string('Passbook')->nullable();
            $table->string('SavingsCode', 10)->nullable();
            $table->char('Status', 1)->nullable();
            $table->dateTime('DDate')->nullable();
            $table->decimal('BMaintain', 19, 4)->default(0);
            $table->boolean('CollectYN')->nullable();
            $table->smallInteger('PMode')->nullable();
            $table->decimal('PAmount', 19, 4)->default(0);
            $table->dateTime('LastPDate')->nullable();
            $table->dateTime('StartCDate')->nullable();
            $table->smallInteger('CurrLine')->nullable();
            $table->smallInteger('CurrPage')->nullable();
            $table->smallInteger('CurrBook')->nullable();
            $table->timestamps();
            $table->foreign('ClientCode')->references('ClientCode')->on('clienteles')->onDelete('cascade');
            // $table->foreign('SavingsCode')->references('SavingsCode')->on('casasavingsproduct')->onDelete('cascade');

        });

        Schema::create('clientsavingsdtl', function (Blueprint $table) {
            $table->string('ID')->primary();
            $table->string('RefNo')->nullable();
            $table->unsignedBigInteger('CSHDRKey')->nullable()->default(0);
            $table->unsignedBigInteger('TransNo')->nullable()->default(0);
            $table->dateTime('TransDate');
            $table->decimal('Amount', 19, 4)->default(0);
            $table->string('Remarks', 100)->nullable();
            $table->string('Type')->nullable();
            $table->string('TransType')->nullable();
            $table->string('Teller')->nullable();
            $table->string('Workstation')->nullable();
            $table->tinyInteger('PrnSlipYN')->default(0);
            $table->tinyInteger('PrnPassbookYN')->default(0);
            $table->tinyInteger('PrnLedgerYN')->default(0);
            $table->char('Status', 10)->nullable();
            $table->string('Batch', 10)->nullable();
            $table->dateTime('Time')->nullable();
            $table->string('TransDesc', 4)->nullable();
            $table->smallInteger('Line')->nullable();
            $table->smallInteger('Page')->nullable();
            $table->smallInteger('Book')->nullable();
            $table->string('CashAccnt', 12)->nullable();
            $table->integer('LineLedger')->default(0);
            $table->integer('PageLedger')->default(0);
            $table->timestamps();
            $table->foreign('CSHDRKey')->references('CSHDRKey')->on('clientsavings')->onDelete('cascade');
            // $table->foreign('TransNo')->references('TransNo')->on('clientsavingsdtl')->onDelete('cascade');
        });

        Schema::create('clientsavingsplan', function (Blueprint $table) {
            $table->id('ClSavID');
            $table->unsignedBigInteger('PolicyID');
            $table->string('ClientCode', 10);
            $table->dateTime('AppDate')->nullable();
            $table->dateTime('StartDate')->nullable();
            $table->integer('StatusCode')->nullable();
            $table->boolean('IsExtended')->nullable();
            $table->string('UserID', 16)->nullable();
            $table->integer('PolUnits')->nullable();
            $table->string('Transcode', 15)->nullable();
            $table->dateTime('StartWaitPeriod')->nullable();
            $table->dateTime('MaturityDate')->nullable();
            $table->decimal('InterestBal', 19, 4)->nullable();
            $table->dateTime('StartExtPeriod')->nullable();
            $table->dateTime('ExtMaturityDate')->nullable();
            $table->string('XTranscode', 15)->nullable();
            $table->dateTime('TerminateDate')->nullable();  
            $table->timestamps();
            $table->foreign('ClientCode')->references('ClientCode')->on('clienteles')->onDelete('cascade');
            // $table->foreign('Transcode')->references('TransCode')->on('trans_codes')->onDelete('cascade');
            // $table->foreign('XTranscode')->references('TransCode')->on('trans_codes')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('clientsavingsplan');
        Schema::dropIfExists('clientsavingsdtl');
        Schema::dropIfExists('clientsavings');
    }
};
