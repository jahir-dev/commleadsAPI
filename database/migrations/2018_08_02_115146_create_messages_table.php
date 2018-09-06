<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->increments('id');
            $table->string('subject');
            $table->text('text');
            $table->dateTime('sentDate');
            $table->boolean('isRead');
            $table->boolean('hasReplied');
            $table->unsignedInteger('offer_id');
            $table->foreign('offer_id')->references('id')->on('offers');
            $table->unsignedInteger('from_buyer');
            $table->foreign('from_buyer')->references('id')->on('buyers');
            $table->unsignedInteger('to_buyer');
            $table->foreign('to_buyer')->references('id')->on('buyers');
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
        Schema::dropIfExists('messages');
    }
}
