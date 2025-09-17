<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('interestrate', function (Blueprint $table) {
            $table->id('RateID');
            $table->decimal('From', 19, 4);
            $table->decimal('To', 19, 4);
            $table->float('iRate');
            $table->string('AcctCode', 12);
            $table->unsignedBigInteger('IntEffDateID');
            $table->tinyInteger('withTax')->default(0)->nullable();
            $table->timestamps();
            $table->foreign('AcctCode')->references('AcctCode')->on('acct_codes')->onDelete('cascade');
            $table->foreign('IntEffDateID')->references('IntEffDateID')->on('inteffdate')->onDelete('cascade');
        });
    }

    public function down(): void {
        Schema::dropIfExists('interestrate');
    }
};
