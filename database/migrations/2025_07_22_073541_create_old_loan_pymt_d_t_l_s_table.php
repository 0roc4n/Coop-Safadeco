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
        Schema::create('old_loan_pymt_d_t_l_s', function (Blueprint $table) {
            $table->unsignedBigInteger('LoanPymtKey')->primary();
            $table->string('CLKey');
            $table->dateTime('PaymentDate');
            $table->decimal('Principal', 19, 4);
            $table->decimal('Interest', 19, 4);
            $table->decimal('Penalty', 19, 4);
            $table->decimal('FSav1', 19, 4);
            $table->decimal('FSav2', 19, 4);
            $table->decimal('FSav3', 19, 4);
            $table->decimal('FSav4', 19, 4);
            $table->decimal('FSav5', 19, 4);
            $table->decimal('TotalPayment', 19, 4);
            $table->string('TransCode', 15);
            $table->string('ORNum', 15)->nullable();
            $table->string('Remarks', 128)->nullable();
            $table->unsignedBigInteger('FolderKey');
            $table->decimal('BalPrin', 19, 4);
            $table->decimal('BalInt', 19, 4);
            $table->decimal('BalPen', 19, 4);
            $table->decimal('BalSav1', 19, 4);
            $table->decimal('BalSav2', 19, 4);
            $table->decimal('BalSav3', 19, 4);
            $table->decimal('BalSav4', 19, 4);
            $table->decimal('BalSav5', 19, 4);
            $table->boolean('IsPaidByAdjust')->nullable();
            $table->string('PaidBy', 10)->nullable();

            // Foreign Keys
            $table->foreign('CLKey')->references('CLKey')->on('client_loans')->onDelete('cascade');
            $table->foreign('FolderKey')->references('FolderKey')->on('books')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('old_loan_pymt_d_t_l_s');
    }
};
