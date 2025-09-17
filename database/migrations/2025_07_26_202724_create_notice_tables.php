<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNoticeTables extends Migration
{
    public function up()
    {
        Schema::create('notice_controlnumber', function (Blueprint $table) {
            $table->id();
            $table->string('Nottype', 20)->nullable();
            $table->string('ControlNumber', 50)->nullable();
            $table->integer('CNumLenght')->nullable();
            $table->string('IsALL', 10)->nullable();
            $table->integer('TmpControlNumber')->nullable();
            $table->timestamps();
        });

        Schema::create('notice_signatories', function (Blueprint $table) {
            $table->id();
            $table->string('Nottype', 20)->nullable();
            $table->string('Nname', 50)->nullable();
            $table->string('Nposition', 50)->nullable();
            $table->string('Cname', 50)->nullable();
            $table->string('Cposition', 50)->nullable();
            $table->timestamps();
        });

        Schema::create('noticesetup', function (Blueprint $table) {
            $table->id('NSupID');
            $table->string('NotType', 50)->nullable();
            $table->string('Descs', 255)->nullable();
            $table->integer('NumDays')->nullable();
            $table->char('MatDays', 25)->nullable();
            $table->char('Remarks', 255)->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('noticesetup');
        Schema::dropIfExists('notice_signatories');
        Schema::dropIfExists('notice_controlnumber');
    }
}
