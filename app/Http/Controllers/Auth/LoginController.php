<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Auth;
use DB;
use App\Models\User;
use Carbon\Carbon;
use Session;
use Brian2694\Toastr\Facades\Toastr;

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

    /**
    * Create a new controller instance.
    *
    * @return void
    */
    public function __construct()
    {
        $this->middleware('guest')->except([
            'logout',
            'locked',
            'unlock'
        ]);
    }
    /** index page login */
    public function login()
    {
        return view('auth.login');
    }

    /** login with databases */
    public function authenticate(Request $request)
    {
        DB::beginTransaction();
        try {
            $request->validate([
                'email' => 'required|string|email',
                'password' => 'required|string',
            ]);

            $username  = $request->email;
            $password = $request->password;


            // Manually verify the password
            $user = User::where('email', $username)->first();
            if ($user && Hash::check($password, $user->password)) {

                Auth::login($user);
                Session::put('name', $user->name);
                Session::put('email', $user->email);

                Toastr::success('Login successfully :)', 'Success');

                DB::commit();

                return redirect()->intended('home');
            } else {

                // Authentication failed
                Toastr::error('Fail, WRONG USERNAME OR PASSWORD :)', 'Error');

                DB::commit();

                return redirect('login');
            }
        } catch (\Exception $e) {
            DB::rollback();


            Toastr::error('Fail, LOGIN :)', 'Error');

            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /** logout */
    public function logout()
    {
        Auth::logout();
        Toastr::success('Logout successfully :)','Success');
        return redirect('login');
    }
}