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
        Schema::create('households', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('addressee');
            $table->string('sortsurname')->nullable();
            $table->string('addr1')->nullable();
            $table->string('addr2')->nullable();
            $table->string('addr3')->nullable();
            $table->string('post1')->nullable();
            $table->string('post2')->nullable();
            $table->string('post3')->nullable();
            $table->string('homephone')->nullable();
            $table->integer('householdcell')->nullable();
            $table->decimal('latitude', 20, 15)->nullable();
            $table->decimal('longitude', 20, 15)->nullable();
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
