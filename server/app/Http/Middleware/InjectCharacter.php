<?php

namespace App\Http\Middleware;

use App\Character;
use Closure;
use Illuminate\Support\Facades\Auth;

class InjectCharacter
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = $request->user();

        if ($user) {
            $character = $user->character->first();

            app()->instance(Character::class, $character);
        }

        return $next($request);
    }
}
