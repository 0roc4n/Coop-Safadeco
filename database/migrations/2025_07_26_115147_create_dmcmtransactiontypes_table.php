<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('dmcmtransactiontypes', function (Blueprint $table) {
            $table->string('Mnemonic', 10)->primary();
            $table->string('ModuleTypeID', 10);
            $table->string('Description', 50);
            $table->string('Module', 10);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dmcmtransactiontypes');
    }
};
