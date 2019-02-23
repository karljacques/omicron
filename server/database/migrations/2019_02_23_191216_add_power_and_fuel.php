<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPowerAndFuel extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ships', function (Blueprint $table) {
            $table->unsignedInteger('max_fuel');

            $table->unsignedInteger('power');
            $table->unsignedInteger('max_power');

            $table->unsignedInteger('shields');
            $table->unsignedInteger('max_shields');

            $table->unsignedInteger('armour');
            $table->unsignedInteger('max_armour');

            $table->unsignedInteger('hit_points');
            $table->unsignedInteger('max_hit_points');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ships', function (Blueprint $table) {
            $table->dropColumn('max_fuel');
            $table->dropColumn('power');
            $table->dropColumn('max_power');

            $table->dropColumn('shields');
            $table->dropColumn('max_shields');

            $table->dropColumn('armour');
            $table->dropColumn('max_armour');

            $table->dropColumn('hit_points');
            $table->dropColumn('max_hit_points');
        });
    }
}
