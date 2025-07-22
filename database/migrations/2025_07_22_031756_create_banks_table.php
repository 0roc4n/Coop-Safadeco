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
        Schema::create('banks', function (Blueprint $table) {
            $table->id();
            $table->string('AcctCode', 20);
            $table->string('BranchName', 50);
            $table->string('BankAcctNo', 20);
            $table->string('Address', 100)->nullable();
            $table->string('TelNo', 20)->nullable();
            $table->string('FaxNo', 20)->nullable();
            $table->string('MobileNo', 20)->nullable();
            $table->string('Contact', 30)->nullable();
            $table->string('Department', 20)->nullable();
            $table->string('Position', 20)->nullable();
            $table->integer('CheckFormat');
            $table->string('BankName', 50);

            $table->foreign('AcctCode')->references('AcctCode')->on('acct_codes')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('banks');
    }
};
