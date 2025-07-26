<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('custominterest', function (Blueprint $table) {
            $table->string('LoanCode', 12)->primary();
            $table->decimal('UpfrontInt', 19, 4);
            $table->integer('UpfrontTerm');
            $table->decimal('AmortInt', 19, 4)->nullable();
            $table->integer('AmortTerm')->nullable();
            $table->decimal('LumpSumInt', 19, 4)->nullable();
            $table->integer('LumpSumTerm')->nullable();
            $table->integer('UsePrincipal')->nullable();
            $table->integer('PrinModeOfComp')->nullable();
            $table->decimal('UpfrontComp', 19, 4)->default(0.0000);
            $table->decimal('AmortComp', 19, 4)->default(0.0000);
            $table->decimal('LumpsumComp', 19, 4)->default(0.0000);
            $table->integer('PymtFrequency')->default(1);
            $table->timestamps();

           
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('custominterest');
    }
};
