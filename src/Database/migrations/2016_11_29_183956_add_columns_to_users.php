<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function ($table) {
            $table->dropColumn('password');
            $table->integer('individual_id')->nullable();
            $table->string('facebook_id')->nullable();
            $table->string('google_id')->nullable();
            $table->string('slack_username')->nullable();
            $table->string('notification_channel')->nullable();
            $table->string('allow_messages')->nullable();
            $table->string('bio')->nullable();
            $table->dropUnique(['email']);
            $table->softDeletes();
        });
        Schema::table('users', function ($table) {
            $table->string('password')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function ($table) {
            $table->dropColumn('individual_id');
            $table->dropColumn('facebook_id');
            $table->dropColumn('google_id');
            $table->dropColumn('slack_username');
            $table->dropColumn('notification_channel');
            $table->dropColumn('bio');
        });
    }
}
