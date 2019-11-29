<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActorMoviesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('actor__movies', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('movie_id');
            $table->foreign('movie_id')
                ->references('id')
                ->on('movies')
                ->onDelete('cascade');

            $table->unsignedInteger('actor_id');
            $table->foreign('actor_id')
                ->references('id')
                ->on('actors')
                ->onDelete('cascade');

            $table->unsignedInteger('role_id');
            $table->foreign('role_id')
                ->references('id')
                ->on('roles')
                ->onDelete('cascade');

            $table->time('playTime');

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
        Schema::dropIfExists('actor__movies');
    }
}
