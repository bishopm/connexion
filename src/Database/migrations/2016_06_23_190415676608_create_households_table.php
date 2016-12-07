<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHouseholdsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('households', function(Blueprint $table) {
			$table->engine = 'InnoDB';
            $table->increments('id');
						$table->string('addressee');
            $table->string('sortsurname');
            $table->string('addr1');
            $table->string('addr2');
            $table->string('addr3');
            $table->string('post1');
            $table->string('post2');
            $table->string('post3');
            $table->string('homephone');
            $table->integer('householdcell');
            $table->decimal('latitude',20,15);
            $table->decimal('longitude',20,15);
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
		Schema::drop('households');
	}
}
