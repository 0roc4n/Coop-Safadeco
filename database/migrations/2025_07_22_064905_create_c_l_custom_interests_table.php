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
        Schema::create('c_l_custom_interests', function (Blueprint $table) {
            $table->id();
            $table->string('CLKey');
            $table->string('LoanCode', 12);
            $table->decimal('UpfrontInt', 19, 4);
            $table->integer('UpfrontTerm');
            $table->decimal('AmortInt', 19, 4)->nullable();
            $table->integer('AmortTerm')->nullable();
            $table->decimal('LumpSumInt', 19, 4)->nullable();
            $table->integer('LumpSumTerm')->nullable();
            $table->integer('UsePrincipal')->nullable();
            $table->integer('PrinModeOfComp')->nullable();
            $table->integer('UpfrontComp');
            $table->integer('AmortComp');
            $table->integer('LumpsumComp');
            $table->integer('PymtFrequency');

            // Foreign key
            $table->foreign('CLKey')->references('CLKey')->on('client_loans')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('c_l_custom_interests');
    }
};
