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
        Schema::create('annual_fees', function (Blueprint $table) {
            $table->string('ClientCode', 10);
            $table->decimal('Amount', 19, 4);
            $table->dateTime('PymtDate')->nullable();
            $table->unsignedBigInteger('Year'); // NUMERIC(18,0)

            $table->foreign('ClientCode')->references('ClientCode')->on('clienteles')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('annual_fees');
    }
};
