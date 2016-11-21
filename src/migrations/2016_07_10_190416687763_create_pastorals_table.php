<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePastoralsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('pastorals', function(Blueprint $table) {
			$table->engine = 'InnoDB';
      $table->increments('id');
			$table->integer('household_id');
      $table->date('pastoraldate');
			$table->string('details');
      $table->string('actiontype');
			$table->integer('individual_id');
      $table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('pastorals');
	}
}
