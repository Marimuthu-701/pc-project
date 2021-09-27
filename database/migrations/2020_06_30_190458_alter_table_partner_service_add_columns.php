<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTablePartnerServiceAddColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('partner_services', function (Blueprint $table) {
            $table->boolean('govt_approved')->default(0)->after('slug')->comment('Status (0 = No, 1 = Yes)');
            $table->string('landline_number', 20)->nullable()->after('contact_email')->comment('Landline Number');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('partner_services', function (Blueprint $table) {
            //
        });
    }
}
