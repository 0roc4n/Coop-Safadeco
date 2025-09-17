<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('passbookparam', function (Blueprint $table) {
            $table->id();
            $table->integer('HeaderHeight')->nullable()->default(1080);
            $table->integer('TranDateLeft')->nullable()->default(128);
            $table->integer('DepIntLeft')->nullable()->default(2648);
            $table->integer('WithdrawLeft')->nullable()->default(1200);
            $table->integer('BalanceLeft')->nullable()->default(4200);
            $table->integer('TransDescLeft')->nullable()->default(5760);
            $table->integer('DetailHeight')->nullable()->default(440);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('passbookparam');
    }
};
