<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSectorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sectors', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('system_id');
            $table->foreign('system_id')->references('id')->on('systems');

            $table->unsignedInteger('x');
            $table->unsignedInteger('y');

            $table->unique(['system_id', 'x', 'y']);

            $table->unsignedInteger('sector_type_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sectors');
    }
}
