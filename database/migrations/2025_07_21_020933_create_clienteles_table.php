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
            $table->string('ClientCode', 10)->primary(); // Primary Key
            $table->string('CenterGrpKey', 20)->nullable(); // YES (NULL)
            $table->string('LastName', 70)->nullable(); // YES (NULL)
            $table->string('FirstName', 70)->nullable(); // YES (NULL)
            $table->string('MiddleName', 70)->nullable(); // YES (NULL)
            $table->dateTime('DateOfMembership')->nullable(); // YES (NULL)
            $table->smallInteger('ClientType')->nullable(); // YES (NULL)
            $table->smallInteger('ClientClass')->nullable(); // YES (NULL)
            $table->smallInteger('EmployeeType')->nullable(); // YES (NULL)
            $table->string('Addr1', 150)->nullable(); // YES (NULL)
            $table->string('Addr2', 64)->nullable(); // YES (NULL)
            $table->string('Addr3', 64)->nullable(); // YES (NULL)
            $table->string('TelNum', 64)->nullable(); // YES (NULL)
            $table->string('PlBirth', 64)->nullable(); // YES (NULL)
            $table->dateTime('DtBirth')->nullable(); // YES (NULL)
            $table->tinyInteger('Sex')->nullable(); // YES (NULL) (tinyint(1) is often boolean)
            $table->string('SpouseName', 64)->nullable(); // YES (NULL)
            $table->smallInteger('EduAtt')->nullable(); // YES (NULL)
            $table->smallInteger('CivStatus')->nullable(); // YES (NULL)
            $table->dateTime('DtOfTerminate')->nullable(); // YES (NULL)
            $table->string('UserRefCD', 6)->nullable(); // YES (NULL)
            $table->decimal('MonthlySalary', 18, 4)->nullable(); // YES (NULL)
            $table->string('SpouseOcc', 50)->nullable(); // YES (NULL)
            $table->decimal('SpouseMonSal', 18, 4)->nullable(); // YES (NULL)
            $table->integer('MemberType')->nullable(); // YES (NULL)
            $table->string('Occupation', 50)->nullable(); // YES (NULL)
            $table->string('Office', 10)->nullable(); // YES (NULL)
            $table->string('Department', 10)->nullable(); // YES (NULL)
            $table->decimal('MFee_amt', 18, 4); // NOT NULL
            $table->string('BankAcctNo', 18)->nullable(); // YES (NULL)
            $table->string('BankBranch', 18)->nullable(); // YES (NULL)
            $table->dateTime('EmploymentDate')->nullable(); // YES (NULL)
            $table->dateTime('ResignationDate')->nullable(); // YES (NULL)
            $table->decimal('MaxShareCapital', 18, 4); // NOT NULL

            // Foreign Key Constraint
            // Assumes 'CenterCode' is the primary key in the 'centers' table.
            $table->foreign('CenterGrpKey')->references('CenterCode')->on('centers')->onDelete('set null');
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
