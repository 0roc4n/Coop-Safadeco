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
        Schema::create('c_i_f_clienteles', function (Blueprint $table) {
            $table->string('CIFKey', 20)->primary(); // Primary Key
            $table->string('ClientCode', 10)->nullable();
            $table->dateTime('DateEncoded')->nullable();
            $table->string('UpdateStatus', 50)->nullable();

            $table->foreign('ClientCode')->references('ClientCode')->on('clienteles')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('c_i_f_clienteles');
    }
};
