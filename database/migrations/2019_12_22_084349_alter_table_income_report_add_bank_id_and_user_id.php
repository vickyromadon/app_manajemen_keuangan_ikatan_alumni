<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableIncomeReportAddBankIdAndUserId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('income_reports', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->default(null)->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->unsignedBigInteger('bank_id')->default(null)->nullable();
            $table->foreign('bank_id')->references('id')->on('banks')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('income_reports', function (Blueprint $table) {
            $table->dropForeign('income_reports_user_id_foreign');
            $table->dropColumn('user_id');

            $table->dropForeign('income_reports_bank_id_foreign');
            $table->dropColumn('bank_id');
        });
    }
}
