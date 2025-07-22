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
        Schema::create('acct_codes', function (Blueprint $table) {
            $table->string('AcctCode', 12)->primary();
            $table->smallInteger('Type');
            $table->smallInteger('SubType')->nullable();
            $table->string('Description', 64)->nullable();
            $table->integer('AcctType')->nullable();
            $table->boolean('HasSL');
            $table->string('RelatedParentCode', 12)->nullable();
            $table->integer('CodeExt');
            $table->integer('XOverride');
            $table->integer('AcctClass')->nullable();
            $table->string('AccumDepCode', 12)->nullable();
            $table->smallInteger('CashFlowType');
            $table->boolean('IsExpAnalysis');
            $table->boolean('isFinance')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('acct_codes');
    }
};
