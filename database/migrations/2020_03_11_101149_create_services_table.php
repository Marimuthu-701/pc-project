<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable()->comment('Service Name');
            $table->boolean('status')->default(1)->comment('Status (0 = inactive, 1 = active)');
            $table->timestamps();

            $table->unique('name');
        });

        Schema::create('facilities', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable()->comment('Facility Name');
            $table->boolean('status')->default(1)->comment('Status (0 = inactive, 1 = active)');
            $table->timestamps();

            $table->unique('name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('services');
        Schema::dropIfExists('facilities');
    }
}
