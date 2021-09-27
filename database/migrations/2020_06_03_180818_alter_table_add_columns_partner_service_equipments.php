<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableAddColumnsPartnerServiceEquipments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('partner_service_equipments', function (Blueprint $table) {
            $table->string('rent_type')->nullable()->after('photo_ids')->comment('Rent Type');
            $table->string('rent', 50)->nullable()->after('rent_type')->comment('Rent');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('partner_service_equipments', function (Blueprint $table) {
            //
        });
    }
}
