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
        Schema::create('client_loan_ints', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->string('CLKey');
            $table->boolean('IntAfterMaturity_YN')->nullable();
            $table->float('MaturityIntRate')->nullable();
            $table->integer('IncIntLOBal_YN')->nullable();
            $table->integer('MaturityIntType')->nullable();

            // Foreign key constraint
            $table->foreign('CLKey')->references('CLKey')->on('client_loans')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('client_loan_ints');
    }
};
