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
        Schema::create('client_histories', function (Blueprint $table) {
            $table->id('HistoryID');
            $table->string('ClientCode', 15);
            $table->string('OfficeCode', 15);
            $table->string('Remarks', 255)->nullable();
            $table->dateTime('FromDate')->nullable();
            $table->dateTime('ToDate')->nullable();

            $table->foreign('ClientCode')
                  ->references('ClientCode')
                  ->on('clienteles')
                  ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('client_histories');
    }
};
