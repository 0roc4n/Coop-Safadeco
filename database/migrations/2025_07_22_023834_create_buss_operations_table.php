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
        Schema::create('buss_operations', function (Blueprint $table) {
            $table->integer('BussOpID')->primary(); // Not auto-incrementing
            $table->string('BussOpCode', 20);
            $table->string('BussOpName', 100);
            $table->string('Remarks', 500)->nullable();
            $table->boolean('IsDefault');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('buss_operations');
    }
};
