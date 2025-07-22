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
        Schema::create('interest_balances', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->unsignedBigInteger('LoanPymtKey');
            $table->string('CLKey');
            $table->dateTime('Pymtdate');
            $table->decimal('AmtDue', 19, 4);
            $table->decimal('AmtPaid', 19, 4);
            $table->decimal('Balance', 19, 4)->nullable();

            // Foreign key constraints
            $table->foreign('LoanPymtKey')
                ->references('LoanPymtKey')->on('loan_pymt_d_t_l_s')
                ->onDelete('cascade');

            $table->foreign('CLKey')
                ->references('CLKey')->on('client_loans')
                ->onDelete('cascade');
                    $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('interest_balances');
    }
};
