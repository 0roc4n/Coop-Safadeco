<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('casaclientsavings', function (Blueprint $table) {
            $table->id('casaclientsavingsID');
            $table->string('BranchCode', 10);
            $table->string('GroupCode', 10);
            $table->string('AccountNumber', 20);
            $table->string('ClientCode', 50)->nullable();
            $table->string('SavingsCode', 50)->nullable();
            $table->integer('CSHDRKey')->nullable();
            $table->string('AccountName', 255)->nullable();
            $table->timestamps();

            $table->foreign('ClientCode')->references('ClientCode')->on('clienteles')->onDelete('cascade');
        });

        Schema::create('casadebitcreditmemomaster', function (Blueprint $table) {
            $table->id();
            $table->dateTime('TransDate');
            $table->dateTime('DatePosted');
            $table->string('Mnemonic', 10);
            $table->string('Remarks', 255);
            $table->integer('Posted');
            $table->string('BatchFileName', 255)->nullable();
            $table->string('CreatedBy', 15)->nullable();
            $table->string('UploadedBy', 15)->nullable();
            $table->string('CASAUser', 15)->nullable();
            $table->timestamps();
        });

        Schema::create('casadebitcreditmemo', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('MasterID');
            $table->dateTime('TransDate');
            $table->string('BranchCode', 15);
            $table->string('GroupCode', 15);
            $table->string('AccountNumber', 20);
            $table->decimal('Debit', 19, 4);
            $table->decimal('Credit', 19, 4);
            $table->string('Mnemonic', 15);
            $table->string('TransCode', 15);
            $table->string('ClientCode', 15);
            $table->string('AcctCode', 15);
            $table->string('LookUpKey', 15);
            $table->string('Remarks', 255);
            $table->string('Validate', 255)->nullable();
            $table->timestamps();

            $table->foreign('MasterID')->references('id')->on('casadebitcreditmemomaster')->onDelete('cascade');
            $table->foreign('ClientCode')->references('ClientCode')->on('clienteles')->onDelete('cascade');
            $table->foreign('AcctCode')->references('AcctCode')->on('acct_codes')->onDelete('cascade');
        });

        Schema::create('casadebitcreditmemofiles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('MasterID');
            $table->string('pdir', 255);
            $table->string('pfileName', 255);
            $table->dateTime('datecreated');
            $table->string('MemoType', 5);
            $table->timestamps();

            $table->foreign('MasterID')->references('id')->on('casadebitcreditmemomaster')->onDelete('cascade');
        });

        Schema::create('casasavingsproduct', function (Blueprint $table) {
            $table->id();
            $table->string('GroupCode', 15)->nullable();
            $table->string('SavingsCode', 15)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('casasavingsproduct');
        Schema::dropIfExists('casadebitcreditmemofiles');
        Schema::dropIfExists('casadebitcreditmemo');
        Schema::dropIfExists('casadebitcreditmemomaster');
        Schema::dropIfExists('casaclientsavings');
    }
};
