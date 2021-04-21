<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProgramsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('programs', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->mediumText('description');
            $table->mediumText('instructions');
            $table->bigInteger('category_id');
            $table->bigInteger('trainer_id');
            $table->string('mode');
            $table->string('thumbnail');
            $table->string('link')->nullable();
            $table->string('duration');
            $table->integer('classes');
            $table->double('price', 15, 8);
            $table->double('trial_price', 15, 8);
            $table->json('images');
            $table->json('dates');
            $table->json('times');
            $table->string('video');
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
        Schema::dropIfExists('programs');
    }
}
