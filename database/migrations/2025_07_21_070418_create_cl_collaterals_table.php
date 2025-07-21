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
        Schema::create('cl_collaterals', function (Blueprint $table) {
            $table->increments('CollatID');
            $table->unsignedInteger('CLKey');
            $table->string('Collateral', 500);
            $table->decimal('Amount', 18, 4);
            $table->string('Remarks', 255)->nullable();
            $table->string('EncodedBy', 15)->nullable();
            $table->dateTime('DateEncoded')->nullable();

            $table->foreign('CLKey')->references('CLKey')->on('client_loans')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cl_collaterals');
    }
};
