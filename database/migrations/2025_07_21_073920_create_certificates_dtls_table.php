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
        Schema::create('certificates_dtls', function (Blueprint $table) {
            $table->increments('CertDtlID');
            $table->string('ClientCode', 10); // Removed auto-increment
            $table->string('CertNumber', 15); // Removed auto-increment
            $table->unsignedInteger('FolderKey');
            $table->decimal('Amount', 18, 4);
            $table->dateTime('CertDate');
            $table->string('Remarks', 255)->nullable();

            $table->foreign('ClientCode')->references('ClientCode')->on('clienteles')->onDelete('cascade');
            $table->foreign('CertNumber')->references('CertNumber')->on('certificates_hdrs')->onDelete('cascade');
            $table->foreign('FolderKey')->references('FolderKey')->on('books')->onDelete('restrict');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('certificates_dtls');
    }
};
