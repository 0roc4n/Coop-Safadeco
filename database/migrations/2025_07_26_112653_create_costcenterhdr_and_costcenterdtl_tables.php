<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('costcenterhdr', function (Blueprint $table) {
            $table->string('CostCenterCode', 20)->primary();
            $table->string('Description', 150)->nullable();
            $table->string('Remarks', 250)->nullable();
            $table->string('Tag', 255)->default('0');
        });

        Schema::create('costcenterdtl', function (Blueprint $table) {
            $table->string('CostCenterCode', 20);
            $table->string('AcctCode', 20);

            // Optional FK constraint if `costcenterhdr` and `acctcodes` exist
            $table->foreign('CostCenterCode')->references('CostCenterCode')->on('costcenterhdr')->onDelete('cascade');
            $table->foreign('AcctCode')->references('AcctCode')->on('acct_codes')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('costcenterdtl');
        Schema::dropIfExists('costcenterhdr');
    }
};
