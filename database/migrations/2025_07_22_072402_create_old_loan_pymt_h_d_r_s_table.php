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
        Schema::create('old_loan_pymt_h_d_r_s', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->string('TransCode', 15);
            $table->string('CLKey')->nullable(); // Assuming bigint to match client_loans
            $table->dateTime('PymtDate')->nullable();
            $table->string('RefNum', 12)->nullable();
            $table->string('Remarks', 128)->nullable();
            $table->string('ORnum', 15)->nullable();
            $table->smallInteger('TransType')->nullable();
            $table->integer('FolderKey');

            $table->foreign('CLKey')->references('CLKey')->on('client_loans')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('old_loan_pymt_h_d_r_s');
    }
};
