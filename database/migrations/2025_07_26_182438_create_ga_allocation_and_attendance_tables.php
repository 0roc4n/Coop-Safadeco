<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('gaallocationardeduction', function (Blueprint $table) {
            $table->id('AutoID');
            $table->string('ClientCode', 50)->nullable();
            $table->string('ClientName', 126)->nullable();
            $table->string('AcctCode', 12)->nullable();
            $table->decimal('RemainingBalance', 19, 4)->nullable();
            $table->decimal('Deduction', 19, 4)->nullable();
            $table->char('ID', 10)->nullable();
            $table->timestamps();
            $table->foreign('ClientCode')->references('ClientCode')->on('clienteles')->onDelete('cascade');
            $table->foreign('AcctCode')->references('AcctCode')->on('acct_codes')->onDelete('cascade');
        });

        Schema::create('gaallocationdeduction', function (Blueprint $table) {
            $table->id('AutoID');
            $table->string('ClientCode', 50)->nullable();
            $table->string('ClientName', 126)->nullable();
            $table->string('AcctCode', 15)->nullable();
            $table->decimal('Amount', 19, 4)->nullable();
            $table->integer('ID')->nullable();
            $table->timestamps();
            $table->foreign('ClientCode')->references('ClientCode')->on('clienteles')->onDelete('cascade');
            $table->foreign('AcctCode')->references('AcctCode')->on('acct_codes')->onDelete('cascade');
        });

        Schema::create('gaallocationdetail', function (Blueprint $table) {
            $table->id('AutoID');
            $table->string('ClientCode', 50)->nullable();
            $table->string('ClientName', 126)->nullable();
            $table->string('AcctCode', 12)->nullable();
            $table->string('Description', 64)->nullable();
            $table->decimal('Balance', 19, 4)->nullable();
            $table->unsignedBigInteger('FolderKey')->nullable();
            $table->decimal('Deduction', 19, 4)->nullable();
            $table->decimal('RemainingBalance', 19, 4)->nullable();
            $table->integer('ID')->nullable();
            $table->string('Type', 2)->nullable();
            $table->string('TransCode', 15)->nullable();
            $table->string('CheckNo', 15)->nullable();
            $table->integer('MemberType')->nullable();
            $table->timestamps();
            $table->foreign('ClientCode')->references('ClientCode')->on('clienteles')->onDelete('cascade');
            $table->foreign('AcctCode')->references('AcctCode')->on('acct_codes')->onDelete('cascade');
            $table->foreign('FolderKey')->references('FolderKey')->on('books')->onDelete('cascade');
            // $table->foreign('TransCode')->references('TransCode')->on('trans_codes')->onDelete('cascade');
        });

        Schema::create('gaallocationheader', function (Blueprint $table) {
            $table->id('AutoID');
            $table->string('AcctCode', 12)->nullable();
            $table->string('DivRef', 15)->nullable();
            $table->string('PatRef', 15)->nullable();
            $table->unsignedBigInteger('FolderKey')->nullable();
            $table->integer('Posted')->nullable();
            $table->dateTime('PostedDate')->nullable();
            $table->string('User', 64)->nullable();
            $table->timestamps();
            $table->foreign('AcctCode')->references('AcctCode')->on('acct_codes')->onDelete('cascade');
            $table->foreign('FolderKey')->references('FolderKey')->on('books')->onDelete('cascade');
        });

        Schema::create('gaattendancedetail', function (Blueprint $table) {
            $table->id('AutoID');
            $table->string('ClientCode', 50)->nullable();
            $table->string('ClientName', 126)->nullable();
            $table->string('NickName', 50)->nullable();
            $table->integer('ID')->nullable();
            $table->timestamps();
            $table->foreign('ClientCode')->references('ClientCode')->on('clienteles')->onDelete('cascade');
            // $table->foreign('AcctCode')->references('AcctCode')->on('acct_codes')->onDelete('cascade');
        });

        Schema::create('gaattendanceheader', function (Blueprint $table) {
            $table->id('AutoID');
            $table->dateTime('Date')->nullable();
            $table->bigInteger('Year')->nullable();
            $table->string('Venue', 100)->nullable();
            $table->string('Theme', 100)->nullable();
            $table->integer('Posted')->nullable();
            $table->timestamps();
            // $table->foreign('AcctCode')->references('AcctCode')->on('acct_codes')->onDelete('cascade');
            // $table->foreign('FolderKey')->references('FolderKey')->on('books')->onDelete('cascade');
        });
    }

    public function down(): void {
        Schema::dropIfExists('gaattendanceheader');
        Schema::dropIfExists('gaattendancedetail');
        Schema::dropIfExists('gaallocationheader');
        Schema::dropIfExists('gaallocationdetail');
        Schema::dropIfExists('gaallocationdeduction');
        Schema::dropIfExists('gaallocationardeduction');
    }
};
