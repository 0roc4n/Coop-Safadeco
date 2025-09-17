<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('pat_ref_posts', function (Blueprint $table) {
            $table->id('ID');
            $table->string('ClientCode', 15)->nullable();
            $table->string('AcctCode', 15)->nullable();
            $table->decimal('CurBal', 19, 4)->nullable();
            $table->decimal('PatRef', 19, 4)->nullable();
            $table->unsignedBigInteger('FolderKey')->nullable();
            $table->string('TransCode', 15)->nullable();
            $table->timestamps();
            $table->foreign('ClientCode')->references('ClientCode')->on('clienteles')->onDelete('cascade');
            $table->foreign('AcctCode')->references('AcctCode')->on('acct_codes')->onDelete('cascade');
            $table->foreign('FolderKey')->references('FolderKey')->on('books')->onDelete('cascade');
            // $table->foreign('TransCode')->references('TransCode')->on('trans_codes');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pat_ref_posts');
    }
};
