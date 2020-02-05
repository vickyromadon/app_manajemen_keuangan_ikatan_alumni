<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountanciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accountancies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('date');
            $table->string('code');
            $table->bigInteger('income');
            $table->bigInteger('expense');
            $table->bigInteger('total');

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
        Schema::dropIfExists('accountancies');
    }
}
