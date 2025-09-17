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
        Schema::create('chart_of_accounts_map_outs', function (Blueprint $table) {
            $table->id();
            $table->string('AcctCode', 15)->nullable();
            $table->string('BOSAccountCode', 20)->nullable();

            $table->foreign('AcctCode')->references('AcctCode')->on('acct_codes')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chart_of_accounts_map_outs');
    }
};
