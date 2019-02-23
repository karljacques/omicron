<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShipsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ships', function (Blueprint $table) {
            $table->inherits('dockable');

            $table->unsignedInteger('character_id');
            $table->foreign('character_id')->references('id')->on('characters');

            $table->unsignedInteger('ship_type_id');
            $table->foreign('ship_type_id')->references('id')->on('ship_types');

            $table->unsignedInteger('fuel');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ships');
    }
}
