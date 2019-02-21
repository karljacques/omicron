<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShipsTable extends Migration
{
    const SHIPS_TABLE = 'ships';
    const SHIP_TYPES_TABLE = 'ship_types';
    const USERS_TABLE = 'users';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(self::SHIPS_TABLE, function (Blueprint $table) {
            $table->inherits('dockable');

            $table->unsignedInteger('user_id');
            $table->foreign('user_id')->references('id')->on(self::USERS_TABLE);

            $table->unsignedInteger('ship_type_id');
            $table->foreign('ship_type_id')->references('id')->on(self::SHIP_TYPES_TABLE);

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
        Schema::dropIfExists(self::SHIPS_TABLE);
    }
}
