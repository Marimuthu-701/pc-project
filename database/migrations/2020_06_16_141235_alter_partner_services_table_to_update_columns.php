<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterPartnerServicesTableToUpdateColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::table('partner_services', function (Blueprint $table) {
            $table->dropForeign(['service_id']);
            $table->unsignedBigInteger('service_id')->nullable()->comment('Service ID')->change();

            $table->dropForeign(['partner_id']);
            $table->dropColumn('partner_id');
        });

        Schema::table('partner_services', function (Blueprint $table) {
            $table->foreign('service_id')->references('id')->on('services')->onDelete('set null')->onUpdate('cascade');
        });
        Schema::enableForeignKeyConstraints();        
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
