<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use function Laravel\Prompts\alert;

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
    // protected $redirectTo = RouteServiceProvider::HOME;
    public function authenticated() {
        $user = Auth::user();
        if($user->level == 1) {
            return redirect('admin/dashboard/item')->with("status","Selamat datang $user->name");
        } else  {
            $checkDbxJob = DB::table('dbxjob')->where('username', '=', $user->username)->get();
            if(count($checkDbxJob) > 0) {
                return redirect('/home')->with("status","Logged in");
            } else {
                Auth::logout();
                return redirect('login')->with('error', 'Anda tidak memiliki akses memasuki halaman CSO');
            }            
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

    public function username()
    { 
        return 'username';
    }

    public function password()
    {
        return bcrypt('password');
    }

    public function level()
    {
        return 'level';
    }

}
