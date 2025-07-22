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
        Schema::create('loan_c_a_s_a_interface_parameters', function (Blueprint $table) {
            $table->id();
            $table->string('dirpathdmcm', 255);
            $table->string('dirpathticket', 255);
            $table->string('BranchCode', 255);
            $table->string('CentralServer', 255)->nullable();
            $table->string('CASADB', 255)->nullable();
            $table->string('AccountingDB', 255)->nullable();
            $table->string('DefaultCASAUser', 15)->nullable();
            $table->string('CIFDB', 50)->nullable();
            $table->string('CentralLoanServer', 50)->nullable();
            $table->string('CASALoanDB', 50)->nullable();
            $table->string('AcctgLoanDB', 50)->nullable();
            $table->string('UploadModeTickets', 20)->nullable();
            $table->string('UploadModeMemos', 20)->nullable();
            $table->string('URLTicketUpload', 255)->nullable();
            $table->string('URLMemoUpload', 255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loan_c_a_s_a_interface_parameters');
    }
};
