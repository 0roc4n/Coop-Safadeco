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
        Schema::create('certificates_hdrs', function (Blueprint $table) {
            $table->string('CertNumber', 15)->primary();
            $table->unsignedInteger('FolderKey');
            $table->decimal('Amount', 18, 4);
            $table->string('Remarks', 255)->nullable();
            $table->dateTime('DateEncoded')->nullable();
            $table->string('EncodedBy', 15)->nullable();

            $table->foreign('FolderKey')->references('FolderKey')->on('books')->onDelete('restrict');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('certificates_hdrs');
    }
};
