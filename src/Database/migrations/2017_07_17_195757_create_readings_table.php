<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReadingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('readings', function(Blueprint $table) {
            $table->increments('id');
            $table->date('readingdate');
            $table->string('description');
            $table->string('readings');
            $table->text('reading1');
            $table->text('reading2');
            $table->text('reading3');
            $table->text('reading4');
            $table->text('copyright');
            $table->timestamps();
        });
    }

    CREATE TABLE `readings` (
        `id` int(11) NOT NULL,
        `readingdate` date NOT NULL,
        `description` varchar(100) DEFAULT NULL,
        `readings` varchar(255) DEFAULT NULL,
        `reading1` text NOT NULL,
        `reading2` text NOT NULL,
        `reading3` text NOT NULL,
        `reading4` text NOT NULL,
        `copyright` text NOT NULL
      )

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('statistics');
    }
}
