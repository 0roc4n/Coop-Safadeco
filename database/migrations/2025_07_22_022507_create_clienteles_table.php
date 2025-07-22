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
        Schema::create('clienteles', function (Blueprint $table) {
            $table->string('ClientCode', 10)->primary();
            $table->string('CenterGrpKey', 20)->nullable();
            $table->string('LastName', 70)->nullable();
            $table->string('FirstName', 70)->nullable();
            $table->string('MiddleName', 70)->nullable();
            $table->dateTime('DateOfMembership')->nullable();
            $table->smallInteger('ClientType')->nullable();
            $table->smallInteger('ClientClass')->nullable();
            $table->smallInteger('EmployeeType')->nullable();
            $table->string('Addr1', 150)->nullable();
            $table->string('Addr2', 64)->nullable();
            $table->string('Addr3', 64)->nullable();
            $table->string('TelNum', 64)->nullable();
            $table->string('PlBirth', 64)->nullable();
            $table->dateTime('DtBirth')->nullable();
            $table->boolean('Sex')->nullable();
            $table->string('SpouseName', 64)->nullable();
            $table->smallInteger('EduAtt')->nullable();
            $table->smallInteger('CivStatus')->nullable();
            $table->dateTime('DtOfTerminate')->nullable();
            $table->string('UserRefCD', 6)->nullable();
            $table->decimal('MonthlySalary', 19, 4)->nullable();
            $table->string('SpouseOcc', 50)->nullable();
            $table->decimal('SpouseMonSal', 19, 4)->nullable();
            $table->integer('MemberType')->nullable();
            $table->string('Occupation', 50)->nullable();
            $table->string('Office', 10)->nullable();
            $table->string('Department', 10)->nullable();
            $table->decimal('MFee_amt', 19, 4);
            $table->string('BankAcctNo', 18)->nullable();
            $table->string('BankBranch', 18)->nullable();
            $table->dateTime('EmploymentDate')->nullable();
            $table->dateTime('ResignationDate')->nullable();
            $table->decimal('MaxShareCapital', 19, 4);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clienteles');
    }
};
