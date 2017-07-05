<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGroupsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('groups', function(Blueprint $table) {
			$table->engine = 'InnoDB';
	  		$table->increments('id');
			$table->string('groupname');
	      	$table->string('slug');
	      	$table->text('description')->nullable();
			$table->string('image')->nullable();
	      	$table->integer('eventdatetime')->nullable();
	      	$table->double('latitude',20,15);
	      	$table->double('longitude',20,15);
	      	$table->integer('leader')->nullable();
	      	$table->string('grouptype');
	      	$table->integer('publish')->nullable();
	      	$table->softDeletes();
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
		Schema::drop('groups');
	}
}
