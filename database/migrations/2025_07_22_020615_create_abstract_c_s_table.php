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
        Schema::create('abstract_c_s', function (Blueprint $table) {
            $table->id();
            $table->integer('Col_no');
            $table->string('AcctCode', 12);;
            $table->string('Description', 64);
            $table->string('Title', 32)->nullable();

            // Foreign key constraint
            $table->foreign('AcctCode')->references('AcctCode')->on('acct_codes')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('abstract_c_s');
    }
};
