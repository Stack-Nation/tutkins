<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('apis', function (Blueprint $table) {
            $table->id();
            $table->string('razorpay_key_id')->default("rzp_test_4PvTP1ZGFwCdHQ");
            $table->string('razorpay_key_secret')->default("BvfBsxE7pa6J9HbFET9bJFU7");
            $table->string('razorpay_account_no')->default("2323230061712199");
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
        Schema::dropIfExists('apis');
    }
}
