<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('dbsettings', function (Blueprint $table) {
            $table->integer('SettingID')->primary();
            $table->string('SettingName', 64)->nullable();
            $table->string('SettingValue', 32)->nullable();
            $table->string('SettingDesc', 32)->nullable();
            $table->integer('SettingIndex')->default(0)->nullable();
            $table->integer('DisplayTag')->default(0)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dbsettings');
    }
};
