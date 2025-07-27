<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('penalty_dues', function (Blueprint $table) {
            $table->id('ID');
            $table->string('clkey', 150)->nullable();
            $table->dateTime('datedue')->nullable();
            $table->decimal('penaltydue', 19, 4)->nullable();
            $table->timestamps();
            $table->foreign('clkey')->references('clkey')->on('client_loans')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penalty_dues');
    }
};
