<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('penalty_account_dues', function (Blueprint $table) {
            $table->id('ID');
            $table->string('Clkey')->nullable();
            $table->unsignedBigInteger('LoanPymtkey')->nullable();
            $table->dateTime('Duedate')->nullable();
            $table->decimal('PreviousDue', 19, 4)->nullable();
            $table->decimal('AmountDue', 19, 4)->nullable();
            $table->decimal('AmountPaid', 19, 4)->nullable();
            $table->decimal('CurrentDue', 19, 4)->nullable();
            $table->dateTime('PostingDate')->nullable();
            $table->dateTime('ActualDueDate')->nullable();
            $table->timestamps();
            $table->foreign('Clkey')->references('Clkey')->on('client_loans')->onDelete('cascade');
            $table->foreign('LoanPymtkey')->references('LoanPymtkey')->on('loan_pymt_d_t_l_s')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penalty_account_dues');
    }
};
