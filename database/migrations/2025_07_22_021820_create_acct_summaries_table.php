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
        Schema::create('acct_summaries', function (Blueprint $table) {
            $table->id();
            $table->string('BranchCode', 32)->default('1');
            $table->string('AcctCode', 10)->nullable();
            $table->string('Type', 1)->nullable();
            $table->dateTime('DateProcessed')->nullable();
            $table->decimal('Amount', 19, 4)->nullable();
            $table->integer('FolderKey')->nullable();

            // Optional foreign key (if AcctCode in acct_codes is varchar(10–12))
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
        Schema::dropIfExists('acct_summaries');
    }
};
