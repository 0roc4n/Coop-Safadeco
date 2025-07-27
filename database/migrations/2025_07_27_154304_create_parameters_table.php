<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParametersTable extends Migration
{
    public function up(): void
    {
        Schema::create('parameters', function (Blueprint $table) {
            $table->id(); // You can remove this if `id` column is not needed
            $table->integer('CMMaxNo')->default(0)->nullable();
            $table->integer('CMMaxAmt')->default(0)->nullable();
            $table->decimal('Restruct_Percent', 19, 4)->default(0.0000)->nullable();
            $table->tinyInteger('GetFromPrincipal')->default(0)->nullable();
            $table->tinyInteger('GetFromInterest')->default(0)->nullable();
            $table->tinyInteger('GetFromSavings')->default(0)->nullable();
            $table->tinyInteger('PromptAcctDtlYN')->default(1)->nullable();
            $table->integer('AutoCR_No')->default(0)->nullable();
            $table->integer('AutoCV_No')->default(0)->nullable();
            $table->integer('AutoJV_No')->default(0)->nullable();
            $table->string('StartCR_No', 20)->nullable();
            $table->string('StartCV_No', 20)->nullable();
            $table->string('StartJV_No', 20)->nullable();
            $table->tinyInteger('AllowEditOR')->default(0)->nullable();
            $table->tinyInteger('AllowEditCV')->default(0)->nullable();
            $table->tinyInteger('AllowEditJV')->default(0)->nullable();
            $table->decimal('MembershipFee', 19, 4)->default(0.0000)->nullable();
            $table->dateTime('StartCollMemFee')->nullable();
            $table->integer('MinBeneficiaries')->default(0)->nullable();
            $table->decimal('ShareCapitalAmt', 19, 4)->default(0.0000)->nullable();
            $table->integer('ShareCapitalNo')->default(0)->nullable();
            $table->tinyInteger('ChargePenalty')->default(0)->nullable();
            $table->integer('PenaltyCharging')->default(2)->nullable();
            $table->integer('PenaltyChargeMode')->default(0)->nullable();
            $table->decimal('PenaltyRate', 19, 4)->default(0.0000)->nullable();
            $table->integer('GracePeriod')->default(0)->nullable();
            $table->decimal('AnnualFee', 19, 4)->default(0.0000)->nullable();
            $table->integer('MinNoOfCM')->default(0)->nullable();
            $table->dateTime('AnnualCollDate')->nullable();
            $table->decimal('MaintainBalance', 19, 4)->default(0.0000)->nullable();
            $table->string('Processing', 50)->nullable();
            $table->integer('MaxLine')->default(0)->nullable();
            $table->integer('MaxPage')->default(0)->nullable();
            $table->string('DBVer', 50)->nullable();
            $table->integer('LnMaxLine')->default(28)->nullable();
            $table->integer('LnMaxPage')->default(10)->nullable();
            $table->tinyInteger('RoundOffAmort')->default(1)->nullable();
            $table->decimal('TimeDepInt', 19, 4)->default(0.0000)->nullable();
            $table->string('TimeDepAcct', 50)->nullable();
            $table->integer('NoDaysYr')->default(360)->nullable();
            $table->integer('NoWksYr')->default(50)->nullable();
            $table->string('aProcessing', 20)->default('BATCH')->nullable();
            $table->string('wProcessing', 20)->default('BATCH')->nullable();
            $table->string('dProcessing', 20)->default('BATCH')->nullable();
            $table->tinyInteger('SysDate')->default(1)->nullable();
            $table->string('DCPRBegin', 20)->nullable();
            $table->string('DCPRReceived', 20)->nullable();
            $table->string('DCPRDisbursed', 20)->nullable();
            $table->string('DCPRNet', 20)->nullable();
            $table->string('DCPREnd', 20)->nullable();
            $table->string('DCPRRecap', 20)->nullable();
            $table->integer('IntBestPractice')->nullable();
            $table->string('DS_Header', 1024)->nullable();
            $table->string('DS_SubHeader', 1024)->nullable();
            $table->tinyInteger('CollectRebateTag')->default(1)->nullable();
            $table->tinyInteger('Repost')->default(1)->nullable();
            $table->integer('PBookSkipLn')->default(14)->nullable();
            $table->integer('PBookSkipLnNo')->default(3)->nullable();
            $table->tinyInteger('MortuaryFundTag')->default(0)->nullable();
            $table->tinyInteger('UpfrontInterestTag')->default(0)->nullable();
            $table->decimal('MinimumPenalty', 19, 4)->default(0.0000)->nullable();
            $table->string('LPymtProcessing', 20)->default('DIRECT')->nullable();
            $table->string('IsSystemAmortDate', 1)->default('0')->nullable();
            $table->decimal('IntOnSavingsMinBalance', 19, 4)->default(0.0000)->nullable();
            $table->integer('PassBookTmplt')->default(0)->nullable();
            $table->integer('TimeDepPostType')->default(0)->nullable();
            $table->integer('TimeDepPostType2')->default(0)->nullable();
            $table->integer('PassBookHdr1')->default(0)->nullable();
            $table->integer('PassBookHdr2')->default(0)->nullable();
            $table->integer('LedgerTmplt')->default(0)->nullable();
            $table->integer('LedgerHdr')->default(0)->nullable();
            $table->integer('LoanPassBookTmplt')->default(0)->nullable();
            $table->integer('LoanPassBookHdr')->default(2)->nullable();
            $table->integer('LoanLedgerTmplt')->default(0)->nullable();
            $table->integer('LoanLedgerHdr')->default(0)->nullable();
            $table->integer('CVTmplt')->default(0)->nullable();
            $table->integer('ORTmplt')->default(0)->nullable();
            $table->integer('JVTmplt')->default(0)->nullable();
            $table->decimal('ParValue', 19, 4)->default(0.0000)->nullable();
            $table->tinyInteger('CMVariable')->default(0)->nullable();
            $table->integer('DisclosureStatementType')->default(1)->nullable();
            $table->tinyInteger('UseLoanNo')->default(1)->nullable();
            $table->tinyInteger('CoMakerType')->default(1)->nullable();
            $table->tinyInteger('ReportSLType')->default(1)->nullable();
            $table->integer('LnPBookSkipLn')->default(14)->nullable();
            $table->integer('LnPBookSkipLnNo')->default(1)->nullable();
            $table->integer('LnMaxLineLedger')->default(36)->nullable();
            $table->integer('LnMaxPageLedger')->default(1)->nullable();
            $table->integer('MaxLineLedger')->default(0)->nullable();
            $table->integer('MaxLoanAmountType')->default(0)->nullable();
            $table->integer('MortBenOverDueLoans')->default(0)->nullable();
            $table->integer('MortBenLengthMember')->default(0)->nullable();
            $table->integer('MortBenMemberAge')->default(0)->nullable();
            $table->integer('MortContOverDueLoans')->default(0)->nullable();
            $table->integer('MortContLengthMember')->default(0)->nullable();
            $table->integer('MortContMemberAge')->default(0)->nullable();
            $table->integer('MortValueLengthMember')->default(0)->nullable();
            $table->integer('MortValueMemberAge')->default(0)->nullable();
            $table->integer('MaxTimeDepLine')->default(0)->nullable();
            $table->integer('MaxTimeDepPage')->default(0)->nullable();
            $table->integer('SkipLineTimeDep')->default(0)->nullable();
            $table->integer('SkipLineTimeDepNo')->default(0)->nullable();
            $table->integer('MaxTimeDepLedgerLine')->default(0)->nullable();
            $table->integer('MaxTimeDepLedgerPage')->default(0)->nullable();
            $table->string('TimeDepIntExpenseAcct', 15)->nullable();
            $table->decimal('FixedDepAllotment', 19, 4)->default(0.0000)->nullable();
            $table->decimal('RefundAllotment', 19, 4)->default(0.0000)->nullable();
            $table->decimal('FixedDepCutOff', 19, 4)->default(0.0000)->nullable();
            $table->decimal('FixedDepValue', 19, 4)->default(0.0000)->nullable();
            $table->decimal('RefundValue', 19, 4)->default(0.0000)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('parameters');
    }
}
