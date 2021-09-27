<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterPartnerHomesTableToAddContactPersonAndContactPhoneColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('partner_homes', function (Blueprint $table) {
            $table->string('contact_person')->after('no_of_rooms')->nullable()->comment('Contact Person');
            $table->string('contact_phone')->after('contact_person')->nullable()->comment('Contact Phone Number');
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
