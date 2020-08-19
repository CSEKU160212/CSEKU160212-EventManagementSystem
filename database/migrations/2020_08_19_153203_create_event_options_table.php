<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_options', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->time('time');
            $table->string('place');
            $table->integer('eventid');
            $table->string('fee');
            $table->timestamps();

            $table->foreign('eventid')->references('id')->on('events');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('event_options');
    }
}
