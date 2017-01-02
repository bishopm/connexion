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
			$table->integer('parent_id')->default(0);
			$table->string('title');
			$table->string('url')->nullable();
			$table->integer('position')->default(0);
			$table->string('target');
			$table->string('icon')->nullable();
			$table->string('class')->nullable();
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