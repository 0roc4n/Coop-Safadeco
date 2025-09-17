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
        Schema::create('loan_ammorts', function (Blueprint $table) {
            $table->id();
            $table->string('CLKey', 10)->nullable();
            $table->dateTime('DateDue')->nullable();
            $table->decimal('Principal', 19, 4)->nullable();
            $table->decimal('Interest', 19, 4)->nullable();
            $table->decimal('FSav1', 19, 4)->nullable();
            $table->decimal('FSav2', 19, 4)->nullable();
            $table->decimal('FSav3', 19, 4)->nullable();
            $table->decimal('FSav4', 19, 4)->nullable();
            $table->decimal('FSav5', 19, 4)->nullable();
            $table->decimal('Balance', 19, 4)->nullable();
            $table->decimal('Arrears', 19, 4)->nullable();
            $table->decimal('AmtPaid', 19, 4)->nullable();
            $table->string('TransCode', 15)->nullable();
            $table->decimal('LastPymt', 19, 4)->nullable();
            $table->boolean('CmtPymt')->nullable();
            $table->decimal('SCharge', 19, 4);
            $table->decimal('PenaltyAmt', 19, 4)->nullable();

            // Foreign key
            $table->foreign('CLKey')->references('CLKey')->on('client_loans')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loan_ammorts');
    }
};
