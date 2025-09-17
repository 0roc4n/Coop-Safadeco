<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('reportlocations', function (Blueprint $table) {
            $table->id('ID'); // ID (auto_increment)
            $table->string('ReportID', 20)->nullable();
            $table->string('ReportDir', 200)->nullable();
            $table->string('ReportFile', 100)->nullable();
            $table->timestamps();
        });

        Schema::create('reportslog', function (Blueprint $table) {  
            $table->id('ID');
            $table->dateTime('ReportDate')->nullable();
            $table->string('ReportName', 20)->nullable();
            $table->integer('ReportType')->nullable();
            $table->dateTime('BeginDate')->nullable();
            $table->dateTime('EndDate')->nullable();
            $table->text('Remarks')->nullable();
            $table->string('UserID', 8)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reportlocations');
        Schema::dropIfExists('reportslog');
    }
};
