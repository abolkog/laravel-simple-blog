<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Overriding the authenticated method. Used to check if user account is verified or no
     * If not then disallow the login
     * @param  \Illuminate\Http\Request  $request
     * @param $user the user object
     */
    protected function authenticated(Request $request, $user)
    {
        if (!$user->verified) { //Not Verified Account
            auth()->logout();
            return back()->with('error', 'You need to verify your email first ya 3am');
        }

        return redirect()->intended($this->redirectPath());
    }
}
