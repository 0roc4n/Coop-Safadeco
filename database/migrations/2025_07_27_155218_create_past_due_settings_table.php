<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('past_due_settings', function (Blueprint $table) {
            $table->id('ID');
            $table->string('Description', 100)->nullable();
            $table->decimal('DTParam', 2, 0)->nullable();
            $table->decimal('IntPDI', 3, 1)->nullable();
            $table->string('DTType', 20)->nullable();
            $table->string('GrpName', 10)->nullable();
            $table->string('Remarks', 100)->nullable();
            $table->string('ReportID', 15)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('past_due_settings');
    }
};
