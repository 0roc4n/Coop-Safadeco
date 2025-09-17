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
        Schema::create('bank_reconcillations', function (Blueprint $table) {
            $table->id('BankReconID');
            $table->decimal('BankBal', 19, 4);
            $table->dateTime('ReconDate');
            $table->string('AcctCode', 12);
            $table->unsignedBigInteger('FolderKey');

            // Foreign Keys
            $table->foreign('AcctCode')
                ->references('AcctCode')
                ->on('acct_codes')
                ->onDelete('restrict');

            $table->foreign('FolderKey')
                ->references('FolderKey')
                ->on('books')
                ->onDelete('restrict');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bank_reconcillations');
    }
};
