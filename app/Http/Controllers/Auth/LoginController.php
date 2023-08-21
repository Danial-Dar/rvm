<?php

namespace App\Http\Controllers\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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
    protected $redirectTo = RouteServiceProvider::HOME;

    protected function redirectTo()
    {
        if (auth()->user()->status == 0) {
            Auth::logout();
            
        }else {
            if (auth()->user()->role == "admin") {
                return 'admin/dashboard';
            }else if (auth()->user()->role == "company") {
                return 'company/dashboard';
            }
            return 'user/dashboard';
            
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

    public function login(Request $request)
    {
        $this->validate($request, [
            'email'           => 'required|max:255|email',
            'password'           => 'required',
        ]);
        $credentials = [
            'email' => strtolower($request->email), 'password' => $request->password
        ];
        if (Auth::attempt($credentials)) {
            if (auth()->user()->status == 0) {
                Auth::logout();
                return redirect()->back()->with('error','Your status is inactive.');
            }else {
                if (auth()->user()->role == "admin") {
                    return redirect()->intended('admin/dashboard');
                }else if (auth()->user()->role == "company") {
                    return redirect()->intended('company/dashboard');
                }
                return redirect()->intended('user/dashboard');
                
            }
        } else {
            // Go back on error (or do what you want)
            return redirect()->back()->with('error','Invalid Credentials.');
        }

    }
}
