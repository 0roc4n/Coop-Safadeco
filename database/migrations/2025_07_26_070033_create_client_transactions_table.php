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
        Schema::create('client_transactions', function (Blueprint $table) {
            $table->id(); // Auto-incrementing primary key

            $table->string('ClientCode', 10)->nullable();
            $table->string('AcctCode', 12)->nullable();
            $table->string('AcctTitle', 64)->nullable();
            $table->decimal('Debit', 19, 4);
            $table->decimal('Credit', 19, 4);
            $table->dateTime('DateOfTran')->nullable();
            $table->string('TransCode', 15);
            $table->unsignedBigInteger('FolderKey')->nullable();
            $table->boolean('Posted');
            $table->dateTime('DatePosted')->nullable();
            $table->string('UserID', 16)->nullable();
            $table->string('TransRef', 15)->nullable();
            $table->string('Journal', 2)->nullable();
            $table->string('FunderCode', 10)->nullable();
            $table->string('PrgCode', 20)->nullable();
            $table->string('LocCode', 10)->nullable();
            $table->string('FCOCode', 10)->nullable();
            $table->string('ChkNumber', 12)->nullable();
            $table->integer('FATranNo')->default(-1)->nullable();

            $table->timestamps();

            // $table->index('TransCode');

            // Optional foreign keys — adjust as needed
            $table->foreign('ClientCode')->references('ClientCode')->on('clienteles')->nullOnDelete();
            $table->foreign('AcctCode')->references('AcctCode')->on('acct_codes')->nullOnDelete();
            $table->foreign('FolderKey')->references('FolderKey')->on('books')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('client_transactions');
    }
};
