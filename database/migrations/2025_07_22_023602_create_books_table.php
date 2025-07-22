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
        Schema::create('books', function (Blueprint $table) {
            $table->id('FolderKey'); // Auto-increment primary key
            $table->string('Description', 32)->nullable();
            $table->dateTime('DateCreated')->nullable();
            $table->dateTime('DateFrom');
            $table->dateTime('DateTo')->nullable();
            $table->dateTime('Closing')->nullable();
            $table->dateTime('Purging')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
