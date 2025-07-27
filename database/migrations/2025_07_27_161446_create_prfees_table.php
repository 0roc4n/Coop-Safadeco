<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('prfees', function (Blueprint $table) {
            $table->id('ID');
            $table->string('AcctCode', 10);
            $table->string('Description', 64)->nullable();
            $table->integer('PymtType')->default(-1)->nullable();
            $table->decimal('Amount', 19, 4)->nullable();
            $table->boolean('ExCludeInLoanProceeds')->nullable();
            $table->tinyInteger('isFinance')->default(0)->nullable();
            $table->string('isFinanceDesc', 255)->default('')->nullable();
            $table->timestamps();
            $table->foreign('AcctCode')->references('AcctCode')->on('acct_codes')->onDelete('cascade');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prfees');
    }
};
