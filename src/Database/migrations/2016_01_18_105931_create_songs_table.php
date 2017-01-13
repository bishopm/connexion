<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSongsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('songs', function(Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('author');
            $table->string('copyright');
            $table->string('key');
            $table->string('tempo');
            $table->string('audio');
            $table->string('video');
            $table->string('music');
            $table->string('musictype');
            $table->text('lyrics');
            $table->text('words');
            $table->integer('user_id');
            $table->softDeletes();
            $table->nullableTimestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('songs');
    }
}
