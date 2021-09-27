<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePartnerServiceEquipmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('partner_service_equipments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('partner_service_id')->nullable()->comment('Partner Service ID');
            $table->foreign('partner_service_id')->references('id')->on('partner_services')->onDelete('cascade')->onUpdate('cascade');

            $table->string('name')->nullable()->comment('Equipment Name');
            $table->text('description')->nullable()->comment('Description');
            $table->string('photo_ids')->nullable()->comment('Photos Media IDs');
            $table->string('rent_per_day', 50)->nullable()->comment('Rent Per Day');
            $table->string('rent_per_week', 50)->nullable()->comment('Rent Per Week');
            $table->string('rent_per_fortnight', 50)->nullable()->comment('Rent Per Fortnight');
            $table->string('rent_per_month', 50)->nullable()->comment('Rent Per Month');

            $table->timestamps();
        });

        Schema::create('partner_service_facilities', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('partner_service_id')->nullable()->comment('Partner Service ID');
            $table->foreign('partner_service_id')->references('id')->on('partner_services')->onDelete('cascade')->onUpdate('cascade');

            $table->unsignedBigInteger('facility_id')->nullable()->comment('Facility ID');
            $table->foreign('facility_id')->references('id')->on('facilities')->onDelete('cascade')->onUpdate('cascade');

        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('partner_service_equipments');
        Schema::dropIfExists('partner_service_facilities');
    }
}
