<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('collectors', function (Blueprint $table) {
            $table->string('CollectorID', 20)->primary();
            $table->string('ClientCode', 20);
            $table->string('Remarks', 150)->nullable();
            $table->timestamps();
            $table->foreign('ClientCode')->references('ClientCode')->on('clienteles')->onDelete('cascade');
        });

        Schema::create('collectorsloc', function (Blueprint $table) {
            $table->id();
            $table->string('CollectorID', 20);
            $table->string('SubLocID', 20);
            $table->dateTime('StartDate')->nullable();
            $table->dateTime('EndDate')->nullable();
            $table->char('IsActive', 10);
            $table->timestamps();
            $table->foreign('CollectorID')->references('CollectorID')->on('collectors')->onDelete('cascade');
            // $table->foreign('SubLocID')->references('SubLocID')->on('locations')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('collectorsloc');
        Schema::dropIfExists('collectors');
    }
};

