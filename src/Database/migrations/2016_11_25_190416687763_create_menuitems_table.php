<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenuitemsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('menuitems', function(Blueprint $table) {
			$table->engine = 'InnoDB';
      		$table->increments('id');
			$table->integer('menu_id');
			$table->integer('page_id');
			$table->integer('parent_id');
			$table->string('label');
			$table->string('uri');
			$table->integer('position');
			$table->string('target');
			$table->string('icon');
			$table->string('class');
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
		Schema::drop('menuitems');
	}
} 