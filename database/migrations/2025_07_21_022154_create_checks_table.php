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
        Schema::create('checks', function (Blueprint $table) {
            $table->increments('CheckID');
            $table->string('AcctCode', 15)->nullable();
            $table->string('TransCode', 20)->nullable();
            $table->decimal('Amount', 18, 4)->nullable();
            $table->string('Payee', 100)->nullable();
            $table->string('Description', 255)->nullable();
            $table->string('CheckNo', 20)->nullable();
            $table->dateTime('CheckDate')->nullable();
            $table->boolean('IsCleared')->nullable();
            $table->string('Remarks', 255)->nullable();
            $table->dateTime('DateEncoded')->nullable();
            $table->timestamps();

            $table->foreign('AcctCode')->references('AcctCode')->on('chart_of_accounts')->onDelete('set null');
            $table->foreign('TransCode')->references('BussOpCode')->on('bussoperations')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('checks');
    }
};
