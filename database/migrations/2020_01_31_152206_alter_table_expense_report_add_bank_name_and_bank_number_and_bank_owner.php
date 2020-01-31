<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableExpenseReportAddBankNameAndBankNumberAndBankOwner extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('expense_reports', function (Blueprint $table) {
            $table->string('bank_name')->nullable()->default(null);
            $table->string('bank_number')->nullable()->default(null);
            $table->string('bank_owner')->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('expense_reports', function (Blueprint $table) {
            $table->dropColumn('bank_name');
            $table->dropColumn('bank_number');
            $table->dropColumn('bank_owner');
        });
    }
}
