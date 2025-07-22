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
        Schema::create('c_l_collaterals', function (Blueprint $table) {
            $table->id('ColID');
            $table->string('CLKey')->nullable();
            $table->string('Collateral', 150)->nullable();
            $table->decimal('Value', 19, 4)->nullable();

            // Foreign key constraint
            $table->foreign('CLKey')->references('CLKey')->on('client_loans')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('c_l_collaterals');
    }
};
