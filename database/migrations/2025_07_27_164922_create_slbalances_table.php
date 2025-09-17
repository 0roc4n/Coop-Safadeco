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
        Schema::create('slbalances', function (Blueprint $table) {
            $table->id('ID');
            $table->unsignedBigInteger('FolderKey');
            $table->integer('Mnth');
            $table->string('AcctCode', 12);
            $table->string('ClientCode', 10);
            $table->decimal('Balance', 19, 4)->nullable();
            $table->timestamps();
            $table->foreign('AcctCode')->references('AcctCode')->on('acct_codes')->onDelete('cascade');
            $table->foreign('ClientCode')->references('ClientCode')->on('clienteles')->onDelete('cascade');
            $table->foreign('FolderKey')->references('FolderKey')->on('books')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('slbalances');
    }
};
