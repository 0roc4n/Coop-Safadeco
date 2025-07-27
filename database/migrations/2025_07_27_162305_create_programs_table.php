<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProgramsTable extends Migration
{
    public function up(): void
    {
        Schema::create('programs', function (Blueprint $table) {
            $table->string('PrgCode', 15)->primary(); // Primary key
            $table->string('PrgDesc', 30)->nullable();
            $table->dateTime('DateFunded')->nullable();
            $table->string('Remarks', 40)->nullable();
            $table->string('UserRefCd', 6)->nullable();
            $table->dateTime('BegDate')->nullable();
            $table->dateTime('EndDate')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('programs');
    }
}
