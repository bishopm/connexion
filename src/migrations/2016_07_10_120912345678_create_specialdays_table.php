<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSpecialdaysTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('specialdays', function(Blueprint $table) {
	      	$table->increments('id');
			$table->integer('household_id');
	      	$table->string('anniversarytype');
			$table->date('anniversarydate');
	      	$table->string('details');
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
		Schema::drop('specialdays');
	}
}
