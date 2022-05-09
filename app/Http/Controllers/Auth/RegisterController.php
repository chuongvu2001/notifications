<?php

namespace App\Http\Controllers\Auth;

use App\Events\UserEvent;
use App\Http\Controllers\Controller;
use App\Notifications\DatabaseNotification;
use App\Notifications\SMSNotification;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Services\Helpers\VonageService;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

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
    protected $redirectTo = RouteServiceProvider::HOME;

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
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'phone_number' => ['required'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param array $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $activeCode = VonageService::generateRandomString();

        $content = "Your activate code is: $activeCode";

        $code = rand(1, 999999);

        $code = VonageService::send($data['phone_number'], $code, $content);
//        $array = ['code' => $code ?? null, 'email' => $data['email']];

//        dd(setCookiee(28));
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'code' => $code,
            'password' => Hash::make($data['password']),
            'phone_number' => $data['phone_number'],
        ]);

        $message = 'Đăng ký tài khoản';

        $user->notify(new DatabaseNotification($user, $message));

        Session::get('user');
        Session::put('user', $user);

        return redirect()->route('user.active');
//        return $user->notify(new SMSNotification($array));
    }
}
