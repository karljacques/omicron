<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDockableCommoditiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dockable_commodities', function (Blueprint $table) {
            $table->unsignedInteger('dockable_id');
            $table->unsignedInteger('commodity_id');

            $table->unsignedInteger('stock');
            $table->unsignedInteger('sell')->nullable();
            $table->unsignedInteger('buy')->nullable();

            $table->unique(['dockable_id', 'commodity_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dockable_commodities');
    }
}
