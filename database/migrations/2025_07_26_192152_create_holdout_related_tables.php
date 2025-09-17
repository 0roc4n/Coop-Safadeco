<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        // Table: holdout
        Schema::create('holdout', function (Blueprint $table) {
            $table->id('HoldOutID');
            $table->string('AutoID');
            $table->unsignedBigInteger('CSHDRKey')->nullable();
            $table->integer('ID')->nullable();
            $table->string('AccountCode')->nullable();
            $table->decimal('Amount', 19, 4)->nullable();
            $table->dateTime('StartDate')->nullable();
            $table->dateTime('EndDate')->nullable();
            $table->dateTime('DateOfTran')->nullable();
            $table->integer('Period')->nullable();
            $table->integer('Unit')->nullable();
            $table->string('Remarks', 64)->nullable();
            $table->integer('Tag')->nullable();
            $table->timestamps();
            $table->foreign('CSHDRKey')->references('CSHDRKey')->on('clientsavings')->onDelete('cascade');
            $table->foreign('AccountCode')->references('AcctCode')->on('acct_codes')->onDelete('cascade');
        });

        // Table: holdoutcollateral
        Schema::create('holdoutcollateral', function (Blueprint $table) {
            $table->id();
            $table->integer('ColID')->nullable();
            $table->unsignedBigInteger('HoldOutID')->nullable();
            $table->timestamps();
            // $table->foreign('ColID')->references('ColID')->on('holdoutcollateral')->onDelete('cascade');
            $table->foreign('HoldOutID')->references('HoldOutID')->on('holdout')->onDelete('cascade');
        });

        // Table: holdoutpolicy
        Schema::create('holdoutpolicy', function (Blueprint $table) {
            $table->id('HoldOutPolicyID');
            $table->string('AutoID');
            $table->integer('ID');
            $table->string('Description', 100);
            $table->integer('Period')->nullable();
            $table->integer('Unit')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('holdoutpolicy');
        Schema::dropIfExists('holdoutcollateral');
        Schema::dropIfExists('holdout');
    }
};
