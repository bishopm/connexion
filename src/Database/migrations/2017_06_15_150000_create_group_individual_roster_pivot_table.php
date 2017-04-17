<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGroupIndividualRosterPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('group_individual_roster', function(Blueprint $table) {
        $table->integer('group_id')->unsigned()->index();
        $table->foreign('group_id')->references('id')->on('groups')->onDelete('cascade');
        $table->integer('individual_id')->unsigned()->index();
        $table->foreign('individual_id')->references('id')->on('individuals')->onDelete('cascade');
        $table->integer('roster_id')->unsigned()->index();
        $table->foreign('roster_id')->references('id')->on('rosters')->onDelete('cascade');
	      $table->date('rosterdate');
	      $table->integer('selection');
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('group_individual_roster');
    }
}
