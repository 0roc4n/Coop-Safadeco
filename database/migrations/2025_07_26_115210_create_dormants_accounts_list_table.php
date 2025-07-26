<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('dormants_accounts_list', function (Blueprint $table) {
            $table->id();
            $table->string('ACCTCODE', 12)->nullable();
            $table->string('SVDESC', 200)->nullable();
            $table->decimal('CHARGEAMT', 19, 4)->nullable();
            $table->string('CLIENTCODE', 12)->nullable();
            $table->string('LNAME', 200)->nullable();
            $table->string('PASSBOOK', 12)->nullable();
            $table->decimal('BALANCE', 19, 4)->nullable();
            $table->unsignedBigInteger('CSHDRKEY')->nullable();
            $table->timestamps();
            $table->foreign('ACCTCODE')->references('AcctCode')->on('acct_codes')->onDelete('cascade');
            $table->foreign('CLIENTCODE')->references('ClientCode')->on('clienteles')->onDelete('cascade');
            $table->foreign('CSHDRKEY')->references('CSHDRKey')->on('clientsavings')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dormants_accounts_list');
    }
};

