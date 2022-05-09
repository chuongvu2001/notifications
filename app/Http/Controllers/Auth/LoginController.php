<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\DatabaseNotification;
use App\Notifications\SMSNotification;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

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
        $this->middleware('guest')->except('logout');
    }

    protected function attemptLogin(Request $request)
    {

        $user = User::where("email", '=', $request->email)->first();

        if (!$user || $user->activate == User::NoActive) {
            Session::get('error', 'Chưa xác minh tài khoản !');

            return redirect()->route('login');
        }

        return $this->guard()->attempt(
            $this->credentials($request), $request->filled('remember')
        );
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function active()
    {
        $user = Session::get('code');
        return view('auth.active', compact('user'));
    }

    /**
     * @param Request $request
     */
    public function saveActive(Request $request)
    {
        $user = User::where('email', '=', $request->email)->first();

        if (!($user->active == 0)) {
            return redirect()->route('login');
        }

        if (!($user->code == $request->code)) {
            return redirect()->route('user.active');
        }

        $user->activate = User::Active;

        $user->save();

        $message = 'Xác minh tài khoản';

        $user->notify(new DatabaseNotification($user, $message));

        $user->notify(new SMSNotification($user));

        return redirect()->route('login');
    }
}
