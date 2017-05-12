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
            $table->text('words')->nullable();
            $table->integer('user_id')->default(0);
            $table->Timestamps();
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
