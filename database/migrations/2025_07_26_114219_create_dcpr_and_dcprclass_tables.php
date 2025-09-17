<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('dcprclass', function (Blueprint $table) {
            $table->integer('ClassID')->primary()->default(0);
            $table->string('ClassName', 255)->nullable()->default('');
            $table->string('Type', 255)->nullable()->default('');
            $table->timestamps();
        });

        Schema::create('dcpr', function (Blueprint $table) {
            $table->integer('DCPRID')->default(0);
            $table->integer('ClassID')->nullable()->default(0);
            $table->string('AcctCode', 255)->nullable()->default('');
            $table->timestamps();
            $table->foreign('ClassID')->references('ClassID')->on('dcprclass')->onDelete('cascade');
            $table->foreign('AcctCode')->references('AcctCode')->on('acct_codes')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dcpr');
        Schema::dropIfExists('dcprclass');
    }
};

