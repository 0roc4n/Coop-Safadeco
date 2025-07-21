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
        Schema::create('casa_debit_credit_memos', function (Blueprint $table) {
            $table->increments('DCID');
            $table->integer('MasterID')->nullable();
            $table->string('ClientCode', 10)->nullable();
            $table->string('AcctCode', 15)->nullable();
            $table->decimal('Amount', 18, 4);
            $table->string('DC', 1);
            $table->dateTime('DateEncoded');
            $table->boolean('IsConfirm')->nullable();
            $table->string('ConfirmationNumber', 20)->nullable();
            $table->string('Reference', 50)->nullable();
            $table->string('Remarks', 255)->nullable();
            $table->dateTime('TransDate')->nullable();

            $table->foreign('ClientCode')->references('ClientCode')->on('clienteles')->onDelete('set null');
            $table->foreign('AcctCode')->references('AcctCode')->on('chart_of_accounts')->onDelete('set null');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('casadebitcreditmemo');
    }
};
