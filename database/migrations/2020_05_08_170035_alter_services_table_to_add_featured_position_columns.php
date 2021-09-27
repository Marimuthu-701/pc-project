<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterServicesTableToAddFeaturedPositionColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('services', function (Blueprint $table) {
            $table->text('description')->after('name')->nullable()->comment('Description');
            $table->boolean('is_featured')->after('description')->default(0)->comment('Featured');
            $table->smallInteger('position')->after('status')->default(0)->comment('Position');
        });

        Schema::table('partner_homes', function (Blueprint $table) {
            $table->timestamp('featured_from')->after('status')->nullable()->comment('Featured From');
            $table->timestamp('featured_to')->after('featured_from')->nullable()->comment('Featured To');
        });

        Schema::table('partner_services', function (Blueprint $table) {
            $table->timestamp('featured_from')->after('status')->nullable()->comment('Featured From');
            $table->timestamp('featured_to')->after('featured_from')->nullable()->comment('Featured To');
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
