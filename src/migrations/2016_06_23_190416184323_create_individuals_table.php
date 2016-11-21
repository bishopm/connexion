<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIndividualsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('individuals', function(Blueprint $table) {
			$table->engine = 'InnoDB';
            $table->increments('id');
			$table->string('title');
            $table->string('surname');
            $table->string('firstname');
            $table->string('greeting');
            $table->string('email');
            $table->date('birthdate');
            $table->string('sex');
            $table->string('photo');
            $table->string('memberstatus');
            $table->integer('household_id');
            $table->string('giving');
            $table->string('officephone');
            $table->string('cellphone');
            $table->string('social');
            $table->string('slug');
            $table->integer('publish');
            $table->string('leadership');
            $table->string('slack');
            $table->text('notes');
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
		Schema::drop('individuals');
	}
}
