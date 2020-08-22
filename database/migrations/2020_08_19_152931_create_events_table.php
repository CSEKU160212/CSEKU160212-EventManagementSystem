<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title', 255);
            $table->string('organized_by', 255);
            $table->string('venue');
            $table->date('event_start_date');
            $table->string('event_length');
            $table->date('reg_start_date');
            $table->date('reg_end_date');
            $table->string('description');
            $table->string('contact_no')->nullable();
            $table->string('contact_email')->nullable();
            $table->integer('userid');
            $table->timestamps();

            $table->foreign('userid')
                    ->references('id')
                    ->on('users')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('events');
    }
}
