<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('finaldestination', function (Blueprint $table) {
            $table->id();
            $table->string('Center', 10)->nullable();
            $table->decimal('LoanedAmt', 19, 4)->default(0.0000)->nullable();
            $table->decimal('Outstanding', 19, 4)->default(0.0000)->nullable();
            for ($i = 1; $i <= 13; $i++) {
                $table->decimal('Period' . $i, 19, 4)->default(0.0000)->nullable();
            }
            $table->timestamps();
            // $table->foreign('Center')->references('Center')->on('centers')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('finaldestination');
    }
};
