<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('closingbalance', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('FolderKey');
            $table->string('FunderCode', 10)->nullable();
            $table->string('AcctCode', 12);
            $table->decimal('BegBalance', 19, 4)->nullable();
            $table->decimal('EndBalance', 19, 4)->nullable();

            $table->foreign('FolderKey')->references('FolderKey')->on('books')->onDelete('cascade');
            $table->foreign('AcctCode')->references('AcctCode')->on('acct_codes')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('closingbalance');
    }
};
