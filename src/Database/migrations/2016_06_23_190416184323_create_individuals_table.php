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
            $table->string('email');
            $table->string('birthdate')->nullable();
            $table->string('sex');
            $table->string('memberstatus');
            $table->integer('household_id');
            $table->string('giving')->nullable();
            $table->string('officephone')->nullable();
            $table->string('cellphone')->nullable();
            $table->string('social')->nullable();
            $table->string('slug')->nullable();
            $table->integer('publish')->nullable();
            $table->integer('service_id')->nullable();
            $table->string('leadership')->nullable();
            $table->string('slack')->nullable();
            $table->text('notes')->nullable();
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
