<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDanaContributionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dana_contributions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('nominal');
            $table->date('transfer_date');
            $table->string('proof');
            $table->string('description')->default(null)->nullable();
            $table->enum('status', ['pending', 'approve', 'reject'])->default('pending');

            $table->unsignedBigInteger('user_id')->default(null)->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->unsignedBigInteger('bank_id')->default(null)->nullable();
            $table->foreign('bank_id')->references('id')->on('banks')->onDelete('cascade');

            $table->unsignedBigInteger('contribution_id')->default(null)->nullable();
            $table->foreign('contribution_id')->references('id')->on('contributions')->onDelete('cascade');

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
        Schema::dropIfExists('dana_contributions');
    }
}
