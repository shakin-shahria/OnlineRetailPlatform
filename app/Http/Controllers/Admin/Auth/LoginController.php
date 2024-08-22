<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
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
    protected $redirectTo = '/admin'; // This is the redirect address

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Uncommenting these will add middleware to your controller:
        // $this->middleware('guest')->except('logout');
        // $this->middleware('auth')->only('logout');
    }

    /**
     * Show the login form for admin users.
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    /**
     * Specify the guard for admin users.
     *
     * @return \Illuminate\Contracts\Auth\Guard
     */
    protected function guard()
    {
        return Auth::guard('admin');
    }

    /**
     * Handle the login request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Request $request)
    {
        // Validate the incoming request
        //$request->validate([
            //'email' => 'required|email',
            //'password' => 'required|min:8',
        //]);
    
        $credentials = $request->only('email', 'password');
    
        // This should dump the credentials array and stop execution
        //dd($credentials);
    
        if (Auth::guard('admin')->attempt($credentials)) {
            return redirect()->intended('/admin/dashboard');
        }
    
         return redirect()->back()->withErrors(['email' => 'Invalid credentials.']);
    }
}
