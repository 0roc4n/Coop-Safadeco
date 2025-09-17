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
        Schema::create('loan_applications', function (Blueprint $table) {
            $table->id('LACode');
            $table->dateTime('DtOfApp')->nullable();
            $table->string('ClientCode', 10)->nullable();
            $table->smallInteger('Approved')->nullable();
            $table->string('UserApproved', 16)->nullable();
            $table->dateTime('ApproveDate')->nullable();
            $table->string('UserRefCd', 6)->nullable();
            $table->boolean('LoanTotalPaid');
            $table->string('Remarks', 128)->nullable();
            $table->float('RatingScore')->nullable();
            $table->unsignedBigInteger('LoanNumber')->nullable();
            $table->smallInteger('LoanType');
            $table->smallInteger('LoanStatus');
            $table->longText('AppRemarks')->nullable();

            $table->foreign('ClientCode')->references('ClientCode')->on('clienteles')->onDelete('cascade');

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loan_applications');
    }
};
