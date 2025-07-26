<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('fadepr', function (Blueprint $table) {
            $table->id('FAKey');
            $table->unsignedBigInteger('FolderKey')->nullable();
            $table->dateTime('PostingDate')->nullable();
            $table->string('TransCode', 15)->nullable();
            $table->dateTime('TranDate')->nullable();
            $table->decimal('TotalAmt', 19, 4)->default(0.0000);
            $table->string('Remarks', 100)->nullable();
            $table->char('StatusCode', 1)->nullable();
            $table->string('UserRefCD', 16)->nullable();
            $table->timestamps();
            $table->foreign('FolderKey')->references('FolderKey')->on('books')->onDelete('cascade');
            // $table->foreign('TransCode')->references('TransCode')->on('trans_codes')->onDelete('cascade');
        });

        Schema::create('fadentries', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('FAKey')->nullable();
            $table->integer('Period')->nullable();
            $table->string('AcctCode', 12)->nullable();
            $table->decimal('Debit', 19, 4)->default(0.0000);
            $table->decimal('Credit', 19, 4)->default(0.0000);
            $table->string('RefTransCode', 15)->nullable();
            $table->string('ItemKey', 21)->nullable();
            $table->dateTime('DepDate')->nullable();
            $table->timestamps();
            $table->foreign('FAKey')->references('FAKey')->on('fadepr')->onDelete('cascade');
            $table->foreign('AcctCode')->references('AcctCode')->on('acct_codes')->onDelete('cascade');
        });

        Schema::create('fadetails', function (Blueprint $table) {
            $table->id();
            $table->dateTime('CoveredDate')->nullable();
            $table->decimal('DepVal', 19, 4)->nullable();
            $table->decimal('AccDep', 19, 4)->nullable();
            $table->decimal('NetBook', 19, 4)->nullable();
            $table->char('Depreciated', 1)->nullable();
            $table->integer('ItemKey')->nullable();
            $table->timestamps();

            // $table->foreign('ItemKey')->references('ItemKey')->on('fassets')->onDelete('cascade');
        });
        Schema::create('fassets', function (Blueprint $table) {
            $table->id('ItemKey');
            $table->string('ItemDesc', 32);
            $table->dateTime('DateOfPurch')->nullable();
            $table->integer('Quantity')->nullable();
            $table->decimal('TotalCost', 19, 4)->nullable();
            $table->integer('EstLife')->nullable();
            $table->decimal('ScrapValue', 19, 4)->nullable();
            $table->smallInteger('CMeth')->nullable();
            $table->string('TransCode', 10)->nullable();
            $table->string('AcctCode', 12)->nullable();
            $table->char('Disposed', 1)->nullable();
            $table->integer('TransNo')->default(0)->nullable();
            $table->string('SerialNo', 50)->nullable();
            $table->string('InventoryNo', 50)->nullable();
            $table->timestamps();
            // $table->foreign('TransCode')->references('TransCode')->on('trans_codes')->onDelete('cascade');
            $table->foreign('AcctCode')->references('AcctCode')->on('acct_codes')->onDelete('cascade');
        });

        Schema::create('fadisposed', function (Blueprint $table) {
            $table->id('FADKey');
            $table->string('TransCode', 15)->nullable();
            $table->dateTime('TranDate')->nullable();
            $table->unsignedBigInteger('ItemKey')->nullable();
            $table->decimal('NetBookAmt', 19, 4)->default(0.0000);
            $table->decimal('LossAmt', 19, 4)->default(0.0000);
            $table->decimal('GainAmt', 19, 4)->default(0.0000);
            $table->string('Remarks', 255)->nullable();
            $table->char('StatusCode', 1)->nullable();
            $table->string('UserRefCd', 16)->nullable();
            $table->decimal('Cash', 19, 4)->default(0.0000);
            $table->unsignedBigInteger('FolderKey')->default(0)->nullable();
            $table->timestamps();
            $table->foreign('ItemKey')->references('ItemKey')->on('fassets')->onDelete('cascade');
        });

        Schema::create('fadisposehdr', function (Blueprint $table) {
            $table->id();
            $table->string('TransCode', 15);
            $table->dateTime('DateOfDisposal');
            $table->decimal('TotalGain', 19, 4);
            $table->decimal('TotalLoss', 19, 4);
            $table->char('Status', 10);
            $table->string('Remarks', 100)->nullable();
            $table->integer('FolderKey')->nullable();
            $table->decimal('TotalCost', 19, 4)->default(0.0000);
            $table->timestamps();
        });

        Schema::create('fassethdr', function (Blueprint $table) {
            $table->id('TranNo');
            $table->string('TransCode', 15)->nullable();
            $table->string('AcctCode', 12)->nullable();
            $table->char('StatusCode', 1)->nullable();
            $table->unsignedBigInteger('FolderKey')->default(0)->nullable();
            $table->timestamps();
            $table->foreign('FolderKey')->references('FolderKey')->on('books')->onDelete('cascade');
            // $table->foreign('TransCode')->references('TransCode')->on('trans_codes')->onDelete('cascade');
            $table->foreign('AcctCode')->references('AcctCode')->on('acct_codes')->onDelete('cascade');
        });

       
    }

    public function down(): void {
        Schema::dropIfExists('fassets');
        Schema::dropIfExists('fassethdr');
        Schema::dropIfExists('fadisposehdr');
        Schema::dropIfExists('fadisposed');
        Schema::dropIfExists('fadetails');
        Schema::dropIfExists('fadentries');
        Schema::dropIfExists('fadepr');
    }
};
