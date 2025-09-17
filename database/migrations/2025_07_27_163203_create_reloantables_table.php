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
        Schema::create('reloantables', function (Blueprint $table) {
            $table->id();
            $table->string('CLKey')->nullable();
            $table->integer('OldLoan')->nullable();
            $table->dateTime('ReloanDate')->nullable();
            $table->decimal('PrinBal', 19, 4)->nullable();
            $table->decimal('IntBal', 19, 4)->nullable();
            $table->smallInteger('ReloanType')->nullable();
            $table->timestamps();
            $table->foreign('CLKey')->references('CLKey')->on('client_loans')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reloantables');
    }
};
