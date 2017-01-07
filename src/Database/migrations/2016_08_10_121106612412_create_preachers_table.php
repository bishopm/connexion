<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePreachersTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('preachers', function(Blueprint $table) {
			$table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('firstname');
            $table->string('surname');
            $table->string('title');
            $table->string('phone')->nullable();
            $table->string('slug');
            $table->text('status');
            $table->text('bio')->nullable();
            $table->text('fullplan')->nullable();
            $table->integer('society_id')->default(0);
            $table->integer('individual_id')->default(0);
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
		Schema::drop('persons');
	}
}
