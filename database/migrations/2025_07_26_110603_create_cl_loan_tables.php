<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('clloanpayments', function (Blueprint $table) {
            $table->id(); // Auto-incrementing primary key

            $table->string('CLKey')->nullable();
            $table->unsignedBigInteger('PCLKey')->nullable();
            $table->decimal('PrincipalAmt', 19, 4)->nullable();
            $table->decimal('InterestAmt', 19, 4)->nullable();

            $table->timestamps();

            // Optional foreign keys
            $table->foreign('CLKey')->references('CLKey')->on('client_loans')->onDelete ('cascade');
            // $table->foreign('PCLKey')->references('CLKey')->on('clientloans')->nullOnDelete();
        });

        Schema::create('clloanpurpose', function (Blueprint $table) {
            $table->id(); // Auto-incrementing primary key

            $table->string('CLKey');
            $table->string('LnPurPoseCode', 15);

            $table->timestamps();

            // Optional foreign key
            $table->foreign('CLKey')->references('CLKey')->on('client_loans')->cascadeOnDelete();
        });
    }

    public function down(): void {
        Schema::dropIfExists('clloanpurpose');
        Schema::dropIfExists('clloanpayments');
    }
};
