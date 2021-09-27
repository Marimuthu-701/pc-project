<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePartnerServiceMediaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('partner_service_media', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('partner_service_id')->comment('Partner Home ID');
            $table->unsignedBigInteger('media_id')->comment('Media ID');

            $table->foreign('partner_service_id')->references('id')->on('partner_services')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('partner_service_media');
    }
}
