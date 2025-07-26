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

            $table->id('CheckID');
            $table->string('CheckNo', 20);
            $table->dateTime('CheckDate');
            $table->decimal('Amount', 19, 4);
            $table->string('TransCode', 15);
            $table->string('AcctCode', 12);

            // Foreign key
            $table->foreign('AcctCode')
                  ->references('AcctCode')
                  ->on('acct_codes')
                  ->onDelete('restrict');

            $table->timestamps();
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
