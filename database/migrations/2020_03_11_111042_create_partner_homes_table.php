<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePartnerHomesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('partner_homes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('partner_id')->comment('Partner ID');
            $table->string('name')->nullable()->comment('Home Name');
            $table->string('address')->nullable()->comment('Home Address');
            $table->integer('no_of_rooms')->unsigned()->nullable()->comment('Number of Rooms');
            $table->text('other_facilities')->nullable()->comment('Other Facilities');
            $table->boolean('status')->default(0)->comment('Status (0 = inactive, 1 = active)');
            $table->timestamps();

            $table->foreign('partner_id')->references('id')->on('partners')->onDelete('cascade')->onUpdate('cascade');
        });

        Schema::create('partner_home_facilities', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('partner_home_id')->comment('Partner Home ID');
            $table->unsignedBigInteger('facility_id')->comment('Facility ID');

            $table->foreign('partner_home_id')->references('id')->on('partner_homes')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('facility_id')->references('id')->on('facilities')->onDelete('cascade')->onUpdate('cascade');
        });

        Schema::create('partner_home_media', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('partner_home_id')->comment('Partner Home ID');
            $table->unsignedBigInteger('media_id')->comment('Media ID');

            $table->foreign('partner_home_id')->references('id')->on('partner_homes')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('media_id')->references('id')->on('media')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('partner_homes');
        Schema::dropIfExists('partner_home_facilities');
        Schema::dropIfExists('partner_home_media');
    }
}
