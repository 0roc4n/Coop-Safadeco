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
        Schema::create('bankrecondetails', function (Blueprint $table) {
            $table->id('BankDetailID');
            $table->unsignedBigInteger('BankReconID');
            $table->string('TransCode', 15);
            $table->unsignedBigInteger('CheckID');

            // Foreign keys
            $table->foreign('BankReconID')
                  ->references('BankReconID')
                  ->on('bank_reconcillations')
                  ->onDelete('cascade');

            $table->foreign('CheckID')
                  ->references('CheckID')
                  ->on('checks')
                  ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bankrecondetails');
    }
};
