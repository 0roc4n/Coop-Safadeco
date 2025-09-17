<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('inteffdate', function (Blueprint $table) {
            $table->id('IntEffDateID');
            $table->dateTime('Date');
            $table->string('AcctCode', 12);
            $table->timestamps();
            $table->foreign('AcctCode')->references('AcctCode')->on('acct_codes')->onDelete('cascade');
        });
    }

    public function down(): void {
        Schema::dropIfExists('inteffdate');
    }
};
