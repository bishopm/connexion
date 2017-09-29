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
			$table->string('title')->nullable();
            $table->string('surname');
            $table->string('firstname');
            $table->string('email')->nullable();
            $table->string('birthdate')->nullable();
            $table->string('sex')->nullable();
            $table->string('image')->nullable();
            $table->string('memberstatus')->nullable();
            $table->integer('household_id');
            $table->integer('giving')->nullable();
            $table->string('officephone')->nullable();
            $table->string('cellphone')->nullable();
            $table->string('social')->nullable();
            $table->string('slug')->nullable();
            $table->integer('publish')->nullable();
            $table->string('servicetime')->nullable();
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
