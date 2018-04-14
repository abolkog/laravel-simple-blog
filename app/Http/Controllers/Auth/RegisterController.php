<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\VerifyUser;

use App\Mail\VerifyEmail;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);

        //Create the verification token
        $verifyUser = new VerifyUser();
        $verifyUser->user_id = $user->id;
        $verifyUser->token = str_random(50);
        $verifyUser->save();

        //Send it to the user via  email
        Mail::to($user->email)->send(new VerifyEmail($user));

        return $user;
    }

    protected function registered(Request $request, $user)
    {
        $this->guard()->logout();
        return redirect()->route('login')->with('success','Account created. You need to verify your email first, please check your inbox');
    }

    /**
     * Verify the user email
     * @param $token The token send by email 
     * @return redirect to the login page with message
     */
    public function verifyEmail($token) {
        $verifyUser = VerifyUser::where('token',$token)->firstOrFail();
        

        if ($verifyUser->user->verified) { //The user account already verified
            return redirect()->route('login')->with('error','This account has been verified already');
        }

        //Verify the user account by flipping the verified flag
        $verifyUser->user->verified = true;
        $verifyUser->user->save();
        return redirect()->route('login')->with('success','Email verified, you can login to the site now');
    }
}
