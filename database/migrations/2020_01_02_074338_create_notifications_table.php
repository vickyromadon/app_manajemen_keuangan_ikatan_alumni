<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('type');
            $table->text('message');
            $table->text('link');
            $table->enum('status', ['unread', 'read'])->default('unread');

            $table->unsignedBigInteger('sender_id')->default(null)->nullable();
            $table->foreign('sender_id', 'fk_sender')->references('id')->on('users')->onDelete('cascade');

            $table->unsignedBigInteger('receiver_id')->default(null)->nullable();
            $table->foreign('receiver_id', 'fk_receiver')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('notifications');
    }
}
