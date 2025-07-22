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
        Schema::create('beneficiaries', function (Blueprint $table) {
            $table->id('BenID');
            $table->string('ClientCode', 10);
            $table->string('Name', 100);
            $table->integer('Age');
            $table->string('Relationship', 30);
            $table->boolean('IsBeneficiary')->nullable();
            $table->boolean('IsDependent')->nullable();
            $table->dateTime('BirthDate')->nullable();

            $table->foreign('ClientCode')
                  ->references('ClientCode')
                  ->on('clienteles')
                  ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('beneficiaries');
    }
};
