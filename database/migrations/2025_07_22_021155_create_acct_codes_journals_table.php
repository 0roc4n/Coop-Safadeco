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
        Schema::create('acct_codes_journals', function (Blueprint $table) {
            $table->id();
            $table->string('AcctCode', 20);
            $table->boolean('IsCR');
            $table->boolean('IsCD');
            $table->boolean('IsNC');

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
        Schema::dropIfExists('acct_codes_journals');
    }
};
