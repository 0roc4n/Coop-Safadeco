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
        Schema::create('adjust_offset_h_d_r_s', function (Blueprint $table) {
            $table->id('TranNo');
            $table->string('ClientCode', 10);
            $table->string('AcctCode', 12);
            $table->string('JVNo', 15);
            $table->dateTime('AdjDate');
            $table->decimal('AdjustedAmt', 19, 4);
            $table->decimal('OffsetAmt', 19, 4);
            $table->decimal('PrincipalBalAmt', 19, 4);
            $table->decimal('PrincipalPaidAmt', 19, 4);
            $table->decimal('InterestBalAmt', 19, 4);
            $table->decimal('InterestPaidAmt', 19, 4);
            $table->decimal('CSav1BalAmt', 19, 4);
            $table->decimal('CSav1PaidAmt', 19, 4);
            $table->decimal('CSav2BalAmt', 19, 4);
            $table->decimal('CSav2PaidAmt', 19, 4);
            $table->decimal('CSav3BalAmt', 19, 4);
            $table->decimal('CSav3PaidAmt', 19, 4);
            $table->decimal('CSav4BalAmt', 19, 4);
            $table->decimal('CSav4PaidAmt', 19, 4);
            $table->decimal('CSav5BalAmt', 19, 4);
            $table->decimal('CSav5PaidAmt', 19, 4);
            $table->decimal('PenaltyBalAmt', 19, 4);
            $table->decimal('PenaltyPaidAmt', 19, 4);
            $table->boolean('ISCloseLoan');
            $table->string('CLKey', 10);
            $table->integer('FolderKey');
            $table->string('Remarks', 100)->nullable();
            $table->char('StatusCode', 1)->nullable();

            // Foreign Keys
            $table->foreign('AcctCode')->references('AcctCode')->on('acct_codes')->onDelete('cascade');
            $table->foreign('ClientCode')->references('ClientCode')->on('clienteles')->onDelete('cascade');
            $table->foreign('CLKey')->references('CLKey')->on('client_loans')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('adjust_offset_h_d_r_s');
    }
};
