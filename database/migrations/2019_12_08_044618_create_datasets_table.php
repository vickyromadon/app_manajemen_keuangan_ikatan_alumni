<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDatasetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('datasets', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nis')->unique();
            $table->string('fullname');
            $table->string('parent_name');
            $table->date('birthdate');
            $table->string('birthplace');
            $table->bigInteger('entrydate');
            $table->bigInteger('outdate');
            $table->enum('status', ['0', '1'])->default('0');

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
        Schema::dropIfExists('datasets');
    }
}
