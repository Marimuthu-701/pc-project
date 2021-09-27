<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserDeleteHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_delete_history', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->nullable()->comment('User Id');
            $table->string('email')->nullable()->comment('Email');
            $table->string('mobile_number', 20)->nullable()->comment('Mobile Number');
            $table->text('reason')->nullable()->comment('Reason');
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
        Schema::dropIfExists('user_delete_history');
    }
}
