<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActionsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('actions', function(Blueprint $table) {
            $table->increments('id');
			$table->string('description');
			$table->integer('folder_id');
			$table->string('status_details')->nullable();
			$table->integer('completed')->nullable();
			$table->integer('individual_id')->nullable();
			$table->integer('project_id')->nullable();
			$table->integer('user_id');
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
		Schema::drop('actions');
	}
}
