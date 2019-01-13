<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;

class LoginController extends Controller
{
//    /**
//        This section prevents logged in users accessing this controller
//     * Create a new controller instance.
//     *
//     * @return void
//     */
//    public function __construct()
//    {
//        $this->middleware('guest')->except('logout');
//    }

    public function postLogin(Request $request)
    {
        $auth = false;
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials, $request->has('remember'))) {
            $auth = true; // Success
        }

        return response()->json([
            'auth' => $auth,
            'intended' => URL::previous()
        ]);
    }

    public function checkAuthenticationStatus() {
        return response()->json([
            'auth' => Auth::check()
        ]);
    }
}
