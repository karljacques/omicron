<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJumpNodes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jump_nodes', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('source_system_id');
            $table->foreign('source_system_id')->references('id')->on('systems');

            $table->unsignedInteger('source_x');
            $table->unsignedInteger('source_y');

            $table->unsignedInteger('destination_system_id');
            $table->foreign('destination_system_id')->references('id')->on('systems');

            $table->unsignedInteger('destination_x');
            $table->unsignedInteger('destination_y');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jump_nodes');
    }
}
