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
        Schema::create('client_loan_ratings', function (Blueprint $table) {
            $table->id(); // Primary Key
            $table->unsignedBigInteger('LACode')->nullable(); 
            $table->string('RatingsCode', 10)->nullable();
            $table->float('RatingsValue')->nullable();
            $table->float('RatingScore')->nullable();
            $table->dateTime('DateRated')->nullable();

            $table->foreign('LACode')->references('LACode')->on('loan_applications')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('client_loan_ratings');
    }
};
