<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('certificateshdr', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('FolderKey')->nullable();
            $table->bigInteger('StartCertNumber')->nullable();
            $table->integer('Posted')->nullable();
            $table->timestamps();
            $table->foreign('FolderKey')->references('FolderKey')->on('books')->onDelete('cascade');
        });

        Schema::create('certificatesdtl', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('CertNumber')->nullable();
            $table->string('ClientCode', 15)->nullable();
            $table->string('ClientName', 128)->nullable();
            $table->decimal('Deposit', 19, 4)->nullable();
            $table->decimal('Withdrawal', 19, 4)->nullable();
            $table->decimal('PaidUpBalance', 19, 4)->nullable();
            $table->decimal('Stocks', 19, 4)->nullable();
            $table->unsignedBigInteger('FolderKey')->nullable();
            $table->timestamps();
            $table->foreign('FolderKey')->references('FolderKey')->on('books')->onDelete('cascade');
            $table->foreign('ClientCode')->references('ClientCode')->on('clienteles')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('certificatesdtl');
        Schema::dropIfExists('certificateshdr');
    }
};
