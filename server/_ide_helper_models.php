<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App{
/**
 * App\Sector
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Sector newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Sector newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Sector query()
 */
	class Sector extends \Eloquent {}
}

namespace App{
/**
 * App\Ship
 *
 * @property-read \App\System $system
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Ship newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Ship newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Ship query()
 */
	class Ship extends \Eloquent {}
}

namespace App{
/**
 * App\ShipType
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ShipType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ShipType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ShipType query()
 */
	class ShipType extends \Eloquent {}
}

namespace App{
/**
 * App\System
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Sector[] $sectors
 * @method static \Illuminate\Database\Eloquent\Builder|\App\System newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\System newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\System query()
 */
	class System extends \Eloquent {}
}

namespace App{
/**
 * App\User
 *
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read \App\Ship $ship
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User query()
 */
	class User extends \Eloquent {}
}

