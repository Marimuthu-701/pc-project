<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterPartnerServicesTableToAddAdditionalColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('partner_services', function (Blueprint $table) {
            $table->dropColumn(['father_name', 'shift_timings', 'charges']);

            $table->string('registration_number')->after('name')->nullable()->comment('Registration/Licence Number');
            $table->string('contact_person')->after('registration_number')->nullable()->comment('Contact Person');
            $table->string('contact_phone', 20)->after('contact_person')->nullable()->comment('Contact Number');
            $table->string('contact_email')->after('contact_phone')->nullable()->comment('Contact Email');

            $table->string('gender', 10)->after('dob')->nullable()->comment('Gender');
            $table->string('id_proof', 30)->after('gender')->nullable()->comment('ID Proof');
            $table->unsignedBigInteger('id_proof_media_id')->after('id_proof')->nullable()->comment('ID Proof Media ID');
            $table->foreign('id_proof_media_id')->references('id')->on('media')->onDelete('set null')->onUpdate('cascade');
            $table->unsignedBigInteger('profile_photo_id')->after('id_proof_media_id')->nullable()->comment('Profile Photo ID');
            $table->foreign('profile_photo_id')->references('id')->on('media')->onDelete('set null')->onUpdate('cascade');

            $table->string('fees_per_shift', 30)->after('total_experience')->nullable()->comment('Fees Per Shift');
            $table->string('fees_per_day', 30)->after('fees_per_shift')->nullable()->comment('Fees Per Day');

            $table->integer('no_of_rooms')->after('fees_per_day')->unsigned()->nullable()->comment('Number of Rooms');
            $table->double('room_rent', 8, 2)->after('no_of_rooms')->nullable()->comment('Room Rent Amount');
            $table->text('other_facilities')->after('room_rent')->nullable()->comment('Other Facilities');

            $table->string('city', 125)->after('address')->nullable()->comment('City');
            $table->string('state', 30)->after('city')->nullable()->comment('State');
            $table->string('postal_code', 10)->after('state')->nullable()->comment('Postal Code');

            $table->string('website_link')->after('additional_info')->nullable()->comment('Website Link');
            $table->string('services_provided')->after('website_link')->nullable()->comment('Services Provided');
            $table->text('tests_provided')->after('services_provided')->nullable()->comment('List of Tests Provided');
            $table->string('project_name')->after('tests_provided')->nullable()->comment('Project Name');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
