<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('pesosinflation', function (Blueprint $table) {
            $table->id('ID');
            $table->integer('InflationYear');
            $table->integer('InflationMonth');
            $table->decimal('InflationRate', 19, 4);
            $table->timestamps();
        });

        Schema::create('pesoslitigation', function (Blueprint $table) {
            $table->id('ID');
            $table->dateTime('AsOfDate');
            $table->decimal('Amount', 19, 4);
            $table->timestamps();
        });

        Schema::create('pesosmapcodes', function (Blueprint $table) {
            $table->id('ID');
            $table->char('MapType', 2);
            $table->string('AcctCode', 12);
            $table->smallInteger('AcctCodeType');
            $table->foreign('AcctCode')->references('AcctCode')->on('acct_codes')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('pesosmembership', function (Blueprint $table) {
            $table->id('ID');
            $table->integer('MembershipYear');
            $table->integer('MembershipMonth');
            $table->integer('TargetMembers');
            $table->timestamps();
        });

        Schema::create('pesosprobassets', function (Blueprint $table) {
            $table->id('ID');
            $table->dateTime('AsOfDate');
            $table->decimal('Amount', 19, 4);
            $table->timestamps();
        });

        Schema::create('pesosrating', function (Blueprint $table) {
            $table->id('ID');
            $table->integer('Category')->nullable();
            $table->decimal('PercentFrom', 19, 4)->nullable();
            $table->decimal('PercentTo', 19, 4)->nullable();
            $table->integer('Range')->nullable();
            $table->decimal('Equivalent', 19, 4)->nullable();
            $table->integer('Condition')->nullable();
            $table->string('Description', 255)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pesosrating');
        Schema::dropIfExists('pesosprobassets');
        Schema::dropIfExists('pesosmembership');
        Schema::dropIfExists('pesosmapcodes');
        Schema::dropIfExists('pesoslitigation');
        Schema::dropIfExists('pesosinflation');
    }
};
