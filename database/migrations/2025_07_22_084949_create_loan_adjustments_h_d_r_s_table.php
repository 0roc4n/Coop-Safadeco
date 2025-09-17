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
        Schema::create('loan_adjustments_h_d_r_s', function (Blueprint $table) {
            $table->id('AdjustHDRID');
            $table->string('TransCode', 15);
            $table->dateTime('DateOfTran');
            $table->string('Remarks', 255);
            $table->char('StatusCode', 1);
            $table->unsignedBigInteger('FolderKey');
            $table->string('ClientCode', 10);
        
            $table->foreign('FolderKey')->references('FolderKey')->on('books')->onDelete('cascade');
            $table->foreign('ClientCode')->references('ClientCode')->on('clienteles')->onDelete('cascade');
        
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loan_adjustments_h_d_r_s');
    }
};
