<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOfficeTable extends Migration
{
    public function up()
    {
        Schema::create('office', function (Blueprint $table) {
            $table->id();
            $table->string('Code', 10);
            $table->string('Description', 64);
            $table->string('Department', 10)->nullable();
            $table->string('Remarks', 64)->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('office');
    }
}
