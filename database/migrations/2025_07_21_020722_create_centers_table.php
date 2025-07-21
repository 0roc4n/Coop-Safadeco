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
        Schema::create('centers', function (Blueprint $table) {
            $table->string('CenterCode', 10)->primary(); // Primary Key
            $table->dateTime('DateFormed'); // NOT NULL
            $table->string('Description', 32)->nullable(); // YES (NULL)
            $table->string('Location', 20)->nullable(); // YES (NULL)
            $table->string('Rank1', 15)->nullable(); // YES (NULL)
            $table->string('Rank2', 15)->nullable(); // YES (NULL)
            $table->string('Rank3', 15)->nullable(); // YES (NULL)
            $table->string('FOfficer1', 15)->nullable(); // YES (NULL)
            $table->string('FOfficer2', 15)->nullable(); // YES (NULL)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('centers');
    }
};
