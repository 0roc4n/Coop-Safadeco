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
        Schema::create('clientele2s', function (Blueprint $table) {
            $table->id('ID');
            $table->string('ClientCode', 10);
            $table->string('MembershipEntry', 5)->nullable();
            $table->dateTime('PreOrientationDate')->nullable();
            $table->string('MembershipOrientationConductedby', 64)->nullable();
            $table->string('Height', 10)->nullable();
            $table->string('Weight', 10)->nullable();
            $table->string('SSS', 20)->nullable();
            $table->string('TIN', 20)->nullable();
            $table->string('Shift', 20)->nullable();
            $table->string('DepartmentOrArea', 32)->nullable();
            $table->string('LocalNo', 20)->nullable();
            $table->string('Degree', 64)->nullable();
            $table->string('SpouseContactNo', 64)->nullable();
            $table->dateTime('SpouseBirthday')->nullable();
            $table->string('SpouseEducationalAttaintment', 64)->nullable();
            $table->string('SpouseDegree', 64)->nullable();
            $table->string('SpouseEmployer', 64)->nullable();
            $table->string('SpouseOfficeAddress', 64)->nullable();
            $table->string('FatherName', 64)->nullable();
            $table->string('FatherOcc', 64)->nullable();
            $table->dateTime('FatherBirthday')->nullable();
            $table->string('FatherOfficeAddress', 64)->nullable();
            $table->string('MotherName', 64)->nullable();
            $table->string('MotherOcc', 64)->nullable();
            $table->dateTime('MotherBirthday')->nullable();
            $table->string('MembershipStatus', 5)->nullable();
            $table->string('EmployerName', 30)->nullable();
            $table->string('OfficeAddress', 100)->nullable();
            $table->string('OfficeZip', 30)->nullable();
            $table->string('OfficePhone', 30)->nullable();
            $table->string('OtherSourceOfIncome', 30)->nullable();
            $table->string('OtherSourceMonthlyIncome', 30)->nullable();
            $table->text('ImagePhoto')->nullable();
            $table->text('ImageSignature')->nullable();
            $table->string('BODResNo', 50);
            $table->dateTime('DateApproved');
            $table->integer('InitCapSubs');
            $table->integer('NoOfShares');
            $table->decimal('amountSubs', 19, 4);
            $table->string('ReligionAffiliation', 150);
            $table->string('BodResNoTerminate', 100)->nullable();

            $table->foreign('ClientCode')->references('ClientCode')->on('clienteles')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clientele2s');
    }
};
