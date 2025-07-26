<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('disbursementaccounts', function (Blueprint $table) {
            $table->id();
            $table->string('LoanCode', 12);
            $table->string('AcctCode', 12);
            $table->tinyInteger('SetAsDefault')->nullable()->default(0);
            $table->timestamps();

            $table->foreign('LoanCode')->references('CLKey')->on('client_loans')->onDelete('cascade');
            $table->foreign('AcctCode')->references('AcctCode')->on('acct_codes')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('disbursementaccounts');
    }
};
