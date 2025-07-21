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
        Schema::create('client_comakers', function (Blueprint $table) {
            $table->increments('CoMakeID');
            $table->unsignedInteger('CLKey');
            $table->string('ClientCode', 10);
            $table->string('Remarks', 255)->nullable();
            $table->dateTime('DateEncoded')->nullable();

            $table->foreign('CLKey')->references('CLKey')->on('client_loans')->onDelete('cascade');
            $table->foreign('ClientCode')->references('ClientCode')->on('clienteles')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('client_comakers');
    }
};
