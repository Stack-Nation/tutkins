<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('username')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->boolean('approved')->default(0);
            $table->string('password');
            $table->string('role');
            $table->string('mobile');
            $table->longText('description')->nullable();
            $table->string('photo')->nullable();
            $table->string('dob')->nullable();
            $table->bigInteger('inst_id')->nullable();
            $table->double('wallet', 15, 8)->default(0);
            $table->string('country')->nullable();
            $table->string('state')->nullable();
            $table->string('city')->nullable();
            $table->mediumText('address')->nullable();
            $table->string('pin_code')->nullable();
            $table->string('aadhar')->nullable();
            $table->string('aadharno')->nullable();
            $table->string('occupation')->nullable();
            $table->string('proficiency')->nullable();
            $table->json('training')->nullable();
            $table->json('parent_info')->nullable();
            $table->boolean('is_org')->default(1);
            $table->boolean('is_trainer')->default(1);
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
