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
        Schema::create('casa_client_savings', function (Blueprint $table) {
            $table->increments('CSID');
            $table->integer('CSHDRKey')->nullable();
            $table->string('ClientCode', 10);
            $table->decimal('Amount', 18, 4);
            $table->dateTime('DateEncoded');
            $table->boolean('IsConfirm')->nullable();
            $table->string('ConfirmationNumber', 20)->nullable();

            $table->foreign('ClientCode')->references('ClientCode')->on('clienteles')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('casa_client_savings');
    }
};
