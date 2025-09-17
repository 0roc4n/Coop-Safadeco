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
        Schema::table('loan_applications', function (Blueprint $table) {
            // Add indexes for better query performance
            $table->index(['ClientCode'], 'idx_loan_applications_client_code');
            $table->index(['LoanStatus'], 'idx_loan_applications_status');
            $table->index(['Approved'], 'idx_loan_applications_approved');
            $table->index(['LoanType'], 'idx_loan_applications_type');
            $table->index(['DtOfApp'], 'idx_loan_applications_date');
            $table->index(['created_at'], 'idx_loan_applications_created');
            $table->index(['LoanNumber'], 'idx_loan_applications_number');
            
            // Composite indexes for common query patterns
            $table->index(['LoanStatus', 'Approved'], 'idx_loan_applications_status_approved');
            $table->index(['ClientCode', 'LoanStatus'], 'idx_loan_applications_client_status');
            $table->index(['LoanType', 'LoanStatus'], 'idx_loan_applications_type_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('loan_applications', function (Blueprint $table) {
            $table->dropIndex('idx_loan_applications_client_code');
            $table->dropIndex('idx_loan_applications_status');
            $table->dropIndex('idx_loan_applications_approved');
            $table->dropIndex('idx_loan_applications_type');
            $table->dropIndex('idx_loan_applications_date');
            $table->dropIndex('idx_loan_applications_created');
            $table->dropIndex('idx_loan_applications_number');
            $table->dropIndex('idx_loan_applications_status_approved');
            $table->dropIndex('idx_loan_applications_client_status');
            $table->dropIndex('idx_loan_applications_type_status');
        });
    }
};