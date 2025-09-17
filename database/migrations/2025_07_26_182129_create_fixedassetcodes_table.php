<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('fixedassetcodes', function (Blueprint $table) {
            $table->id();
            $table->string('AcctCode', 15)->nullable();
            $table->string('AccumDepCode', 15)->nullable();
            $table->string('DepExpense', 15)->nullable();
            $table->timestamps();
            $table->foreign('AcctCode')->references('AcctCode')->on('acct_codes')->onDelete('cascade');
           
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fixedassetcodes');
    }
};
