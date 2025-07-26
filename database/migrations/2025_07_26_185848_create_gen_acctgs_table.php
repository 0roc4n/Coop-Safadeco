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
        Schema::create('gen_acctgs', function (Blueprint $table) {
            $table->id();
            $table->char('StatusCode', 1)->nullable();
            $table->string('TransCode', 15)->nullable();
            $table->dateTime('DateOfTran');
            $table->string('ClientCode', 10);
            $table->decimal('TotalAmt', 19, 4);
            $table->string('Remarks', 255)->nullable();
            $table->unsignedBigInteger('FolderKey')->nullable();
            $table->char('ModuleType', 1)->nullable();
            $table->integer('BussOpID')->nullable();
            $table->timestamps();
            $table->foreign('ClientCode')->references('ClientCode')->on('clienteles')->onDelete('cascade');
            $table->foreign('FolderKey')->references('FolderKey')->on('books')->onDelete('cascade');
            // $table->foreign('TransCode')->references('TransCode')->on('trans_codes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gen_acctgs');
    }
};
