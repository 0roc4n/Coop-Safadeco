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
        Schema::create('chart_of_accounts_map_outs', function (Blueprint $table) {
            $table->increments('MapID');
            $table->string('AcctCode', 15);
            $table->string('BOSAccountCode', 15);
            $table->dateTime('DateEncoded')->nullable();

            $table->foreign('AcctCode')->references('AcctCode')->on('chart_of_accounts')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chart_of_accounts_map_outs');
    }
};
