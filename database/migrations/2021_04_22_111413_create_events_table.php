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
            $table->string('title');
            $table->mediumText('description');
            $table->mediumText('instructions');
            $table->bigInteger('category_id');
            $table->bigInteger('organiser_id');
            $table->string('mode');
            $table->string('thumbnail');
            $table->string('link')->nullable();
            $table->string('country')->nullable();
            $table->string('state')->nullable();
            $table->string('city')->nullable();
            $table->mediumText('address')->nullable();
            $table->string('pin_code')->nullable();
            $table->string('duration');
            $table->integer('days');
            $table->double('price', 15, 8);
            $table->json('images');
            $table->json('dates');
            $table->json('times');
            $table->string('video');
            $table->json('feedback')->nullable();
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
        Schema::dropIfExists('events');
    }
}
