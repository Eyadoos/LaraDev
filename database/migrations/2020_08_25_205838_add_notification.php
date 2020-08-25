<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNotification extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('persons', function (Blueprint $table) {
            $table->boolean('eventNotifications')->default(1);
            $table->boolean('shiftNotifications')->default(1);
            $table->boolean('generalNotifications')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('persons', function (Blueprint $table) {
            $table->dropColumn('eventNotifications');
            $table->dropColumn('shiftNotifications');
            $table->dropColumn('generalNotifications');
        });
    }
}
