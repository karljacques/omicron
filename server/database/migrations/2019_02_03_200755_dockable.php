<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Dockable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dockable', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->unsignedInteger('system_id');

            $table->unsignedInteger('position_x');
            $table->unsignedInteger('position_y');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dockable');
    }
}
