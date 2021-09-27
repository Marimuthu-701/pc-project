<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTablePartnerHomesOfPartnerHomes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('partner_homes', function (Blueprint $table) {
            $table->boolean('verified')->after('featured_to')->default(0)->comment('0 Not verified, 1 Verified');
        });

        Schema::table('partner_services', function (Blueprint $table) {
            $table->boolean('verified')->after('featured_to')->default(0)->comment('0 Not verified, 1 Verified');
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
