<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterUsersTableToAddAdditionalColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('mobile_number', 20)->nullable()->after('email')->comment('Mobile Number');
            $table->string('type', 20)->default('user')->after('remember_token')->comment('Type (user / partner)');
            $table->boolean('status')->default(0)->after('type')->comment('Status (0 = inactive, 1 = active, 2 = pending)');
            $table->string('facebook_id', 50)->nullable()->after('status')->comment('Facebook User ID');
            $table->string('google_id', 50)->nullable()->after('facebook_id')->comment('Google User ID');
            $table->dropColumn('name');
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
