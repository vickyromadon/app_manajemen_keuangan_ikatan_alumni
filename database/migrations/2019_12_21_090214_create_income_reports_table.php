<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIncomeReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('income_reports', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('entry_date');
            $table->enum('type', ['donation', 'event', 'contribution']);
            $table->bigInteger('nominal');
            $table->text('description');

            $table->unsignedBigInteger('dana_donation_id')->default(null)->nullable();
            $table->foreign('dana_donation_id')->references('id')->on('dana_donations')->onDelete('cascade');

            $table->unsignedBigInteger('dana_event_id')->default(null)->nullable();
            $table->foreign('dana_event_id')->references('id')->on('dana_events')->onDelete('cascade');

            $table->unsignedBigInteger('dana_contribution_id')->default(null)->nullable();
            $table->foreign('dana_contribution_id')->references('id')->on('dana_contributions')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('income_reports');
    }
}
