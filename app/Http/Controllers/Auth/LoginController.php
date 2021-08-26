<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

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
    //protected $redirectTo = "admin/dashboard";

    public function redirectTo() {
        if(auth()->user()->hasrole('voter'))
        {
            return 'home';
        }else{
            return 'admin/dashboard';
        }
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    protected function authenticated(Request $request, $user)
    {
        if ($user->status == 'inactive') {
            Auth::logout();
            return back()->with('LoginStatusError', 'Your account has been disabled. Please contact with site authority for more informations.');
        }

        if ($user->status == 'block') {
            Auth::logout();
            return back()->with('LoginStatusError', 'Your account has been blocked. Please contact with site authority for more informations.');
        }
    }
}
