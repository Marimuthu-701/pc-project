<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterPartnerServicesToChangeIdProofMediaIdColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('partner_services', function (Blueprint $table) {
            $table->dropForeign(['id_proof_media_id']);
        });

        Schema::table('partner_services', function (Blueprint $table) {
            $table->string('id_proof_media_id')->nullable()->comment('ID Proof Media IDs')->change();
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
