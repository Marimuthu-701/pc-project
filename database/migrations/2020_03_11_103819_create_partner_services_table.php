<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePartnerServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('partner_services', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('partner_id')->comment('Partner ID');
            $table->unsignedBigInteger('service_id')->comment('Service ID');
            $table->string('name')->nullable()->comment('Person Name');
            $table->string('father_name')->nullable()->comment('Father Name');
            $table->date('dob')->nullable()->comment('Date of Birth');
            $table->string('qualification', 100)->nullable()->comment('Qualification');
            $table->year('year_of_passing')->nullable()->comment('Year of Passing');
            $table->string('college_name')->nullable()->comment('College Name');
            $table->string('working_at')->nullable()->comment('Currently Working At');
            $table->string('specialization_area')->nullable()->comment('Area of Specialization');
            $table->string('total_experience', 50)->nullable()->comment('Total Years of Relevant Experience');
            $table->string('shift_timings', 50)->nullable()->comment('Preferred Shift Timings');
            $table->double('charges', 8, 2)->nullable()->comment('Charges/shift');
            $table->string('address')->nullable()->comment('Residential Address');
            $table->text('additional_info')->nullable()->comment('Additional Information');
            $table->boolean('status')->default(0)->comment('Status (0 = inactive, 1 = active)');
            $table->timestamps();

            $table->foreign('partner_id')->references('id')->on('partners')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('service_id')->references('id')->on('services')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('partner_services');
    }
}
