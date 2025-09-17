<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('pd_checks', function (Blueprint $table) {
            $table->id('ID');
            $table->unsignedBigInteger('LACode')->nullable();
            $table->string('ClientCode', 10)->nullable();
            $table->dateTime('CheckDate')->nullable();
            $table->integer('CheckNum')->nullable();
            $table->dateTime('DateDue')->nullable();
            $table->string('LoanCode', 40)->nullable();
            $table->string('Bank', 50)->nullable();
            $table->decimal('Amount', 19, 4)->nullable();
            $table->string('Funder', 2)->nullable();
            $table->string('Program', 2)->nullable();
            $table->string('Location', 2)->nullable();
            $table->string('TransCode', 12)->nullable();
            $table->timestamps();
            $table->foreign('ClientCode')->references('ClientCode')->on('clienteles')->onDelete('cascade');
            $table->foreign('LACode')->references('LACode')->on('loan_applications')->onDelete('cascade');
            // $table->foreign('TransCode')->references('TransCode')->on('trans_codes')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pd_checks');
    }
};
