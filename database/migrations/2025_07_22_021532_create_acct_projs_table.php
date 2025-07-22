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
        Schema::create('acct_projs', function (Blueprint $table) {
            $table->id();
            $table->string('BranchCode', 32)->default('1');
            $table->string('AcctCode', 12);
            $table->decimal('InitBalance', 19, 4)->nullable();

            // Monthly projection and actuals
            $months = ['JAN', 'FEB', 'MAR', 'APR', 'MAY', 'JUN', 'JUL', 'AUG', 'SEP', 'OCT', 'NOV', 'DEC'];
            foreach ($months as $month) {
                $table->decimal($month, 19, 4)->nullable();
                $table->decimal("ACT_{$month}", 19, 4)->nullable();
            }

            $table->integer('FolderKey')->nullable();

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
        Schema::dropIfExists('acct_projs');
    }
};
