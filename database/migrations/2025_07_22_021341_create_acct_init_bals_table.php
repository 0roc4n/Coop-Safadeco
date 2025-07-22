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
        Schema::create('acct_init_bals', function (Blueprint $table) {
            $table->id(); // Auto-increment primary key
            $table->string('AcctCode', 12);
            $table->dateTime('BegDate')->nullable();
            $table->decimal('BegBal', 19, 4)->nullable();
            $table->dateTime('BalUpdated');

            // Foreign key to acct_codes
            $table->foreign('AcctCode')
                  ->references('AcctCode')
                  ->on('acct_codes')
                  ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('acct_init_bals');
    }
};
