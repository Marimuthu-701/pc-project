<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePartnersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('partners', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->comment('User ID');
            $table->string('name')->nullable()->comment('Business Name');
            $table->string('type', 20)->default('service')->comment('Type (home / service)');
            $table->text('about')->nullable()->comment('Business Description');
            $table->string('city', 125)->nullable()->comment('City');
            $table->string('state', 30)->nullable()->comment('State');
            $table->string('postal_code', 10)->nullable()->comment('Postal Code');
            $table->timestamps();

            $table->unique('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('partners');
    }
}
