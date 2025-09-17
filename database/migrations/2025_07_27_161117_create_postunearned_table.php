<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('postunearned', function (Blueprint $table) {
            $table->id('ID');
            $table->string('CLKey')->nullable()->default(0);
            $table->decimal('Unearned', 19, 4)->nullable()->default(0.0000);
            $table->decimal('Earned', 19, 4)->nullable()->default(0.0000);
            $table->decimal('Balance', 19, 4)->nullable()->default(0.0000);
            $table->dateTime('DatePosted')->nullable();
            $table->integer('PostingID')->nullable()->default(0);
            $table->string('TransCode', 50)->nullable()->default('');
            $table->integer('type')->nullable()->default(0);
            $table->string('CreditAcct', 15)->nullable();
            $table->timestamps();
            $table->foreign('CLKey')->references('CLKey')->on('client_loans')->onDelete('cascade');
            // $table->foreign('CreditAcct')->references('AcctCode')->on('acct_codes')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('postunearned');
    }
};
