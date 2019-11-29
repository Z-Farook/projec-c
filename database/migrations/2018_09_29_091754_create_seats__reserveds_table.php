<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSeatsReservedsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seats__reserveds', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('seat_id');
            $table->foreign('seat_id')
                ->references('id')
                ->on('seats')
                ->onDelete('cascade');

            $table->unsignedInteger('show_id');
            $table->foreign('show_id')
                ->references('id')
                ->on('shows')
                ->onDelete('cascade');

            $table->unsignedInteger('reservation_id');
            $table->foreign('reservation_id')
                ->references('id')
                ->on('reservations')
                ->onDelete('cascade');

            $table->timestamps();

            $table->unique(['seat_id', 'show_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('seats__reserveds');
    }
}
