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
        Schema::create('bank_charges', function (Blueprint $table) {
            $table->id();
            
            $table->char('ChargeType', 1)->nullable();
            $table->string('TransCode')->nullable();
            $table->string('ClientCode', 10)->nullable();
            $table->string('SavingsCode', 15)->nullable();
            $table->string('Passbook', 15)->nullable();
            $table->dateTime('Period')->nullable();
            $table->decimal('Amount', 19, 4)->default(0.0000);
            $table->tinyInteger('Except_yn')->default(0);
            $table->dateTime('PostingDate')->nullable();
            $table->string('Remarks', 255)->nullable();
            $table->unsignedBigInteger('FolderKey')->nullable();
            $table->decimal('AmtPaid', 19, 4)->default(0.0000);

            // Foreign keys (if referenced tables exist and are named appropriately)
            // $table->foreign('TransCode')->references('TransCode')->on('loan_adjustments_d_t_l_s')->onDelete('set null');
            $table->foreign('ClientCode')->references('ClientCode')->on('clienteles')->onDelete('set null');
            $table->foreign('FolderKey')->references('FolderKey')->on('books')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bank_charges');
    }
};
