<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsOfPartnerServices extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('partner_services', function (Blueprint $table) {
            $table->boolean('show_at_home')->default(0)->after('featured_to')->comment('Show Home(1 = Yes, 0 = No)');
            $table->integer('position')->nullable()->after('show_at_home')->comment('Position');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        
    }
}
