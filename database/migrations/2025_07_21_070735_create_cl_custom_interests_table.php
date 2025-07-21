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
        Schema::create('cl_custom_interests', function (Blueprint $table) {
            $table->increments('CIKey');
            $table->unsignedInteger('CLKey');
            $table->string('LoanCode', 15);
            $table->decimal('InterestAmount', 18, 4);
            $table->string('Remarks', 255)->nullable();
            $table->dateTime('EncodedDate')->nullable();
            $table->string('EncodedBy', 15)->nullable();

            $table->foreign('CLKey')->references('CLKey')->on('client_loans')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cl_custom_interests');
    }
};
