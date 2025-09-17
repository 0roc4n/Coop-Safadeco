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
        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id(); // Add a primary key for Laravel compatibility
            $table->dateTime('AuditDate');
            $table->string('UserID', 16);
            $table->string('Action', 20);
            $table->text('Remarks');
            $table->string('RecordType', 10);
            $table->string('TransactionID', 15)->nullable();
            $table->string('UserOverride', 16)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('audit_logs');
    }
};
