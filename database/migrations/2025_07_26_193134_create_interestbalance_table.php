<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('interestbalance', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('LoanPymtKey');
            $table->string('CLKey');
            $table->dateTime('Pymtdate');
            $table->decimal('AmtDue', 19, 4);
            $table->decimal('AmtPaid', 19, 4);
            $table->decimal('Balance', 19, 4)->nullable();
            $table->timestamps();
            $table->foreign('CLKey')->references('CLKey')->on('client_loans')->onDelete('cascade');
            $table->foreign('LoanPymtKey')->references('LoanPymtKey')->on('loan_pymt_d_t_l_s')->onDelete('cascade');
        });
    }

    public function down(): void {
        Schema::dropIfExists('interestbalance');
    }
};
