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
        Schema::create('adjust_offset_d_t_l_s', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->unsignedBigInteger('TranNo');
            $table->string('SavingsCode', 12);
            $table->decimal('BalanceAmt', 19, 4);
            $table->decimal('OffsetAmt', 19, 4);
        
            // Foreign key
            $table->foreign('TranNo')->references('TranNo')->on('adjust_offset_h_d_r_s')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('adjust_offset_d_t_l_s');
    }
};
