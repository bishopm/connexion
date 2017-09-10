<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSettingsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('settings', function(Blueprint $table) {
			$table->engine = 'InnoDB';
      		$table->increments('id');
			$table->string('setting_key')->nullable();
      		$table->string('setting_value',512)->nullable();
      		$table->string('description')->nullable();
			$table->string('label')->nullable();
			$table->string('module')->nullable();
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
		Schema::drop('settings');
	}
} 