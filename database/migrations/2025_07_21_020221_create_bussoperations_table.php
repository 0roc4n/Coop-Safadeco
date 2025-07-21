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
        Schema::create('bussoperations', function (Blueprint $table) {
                $table->increments('BussOpID'); // Primary Key, auto-incrementing
                $table->string('BussOpCode', 20)->unique(); // NOT NULL, unique code
                $table->string('BussOpName', 100); // NOT NULL
                $table->string('Remarks', 500)->nullable(); // YES (NULL)
                $table->tinyInteger('IsDefault'); // NOT NULL (tinyint(1) typically maps to boolean, but here it's just a tinyint)
                $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bussoperations');
    }
};
