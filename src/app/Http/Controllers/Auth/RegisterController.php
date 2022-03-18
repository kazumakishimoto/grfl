<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Socialite\Facades\Socialite;
use App\Rules\CustomPasswordValidation;

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
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', new CustomPasswordValidation, 'confirmed'],
        ]);
    }

    public function showProviderUserRegistrationForm(Request $request, string $provider)
    {
        $token = $request->token;

        $providerUser = Socialite::driver($provider);

        //google
        if ($provider === 'google') {
            $providerUser = $providerUser->userFromToken($token);

            return view('auth.social_register', [
                'provider' => $provider,
                'email' => $providerUser->getEmail(),
                'token' => $providerUser->token,
            ]);

            //twitter
        } elseif ($provider === 'twitter') {
            $tokenSecret = $request->tokenSecret;
            $providerUser = $providerUser->userFromTokenAndSecret($token, $tokenSecret);

            return view('auth.social_register', [
                'provider' => $provider,
                'twitter_id' => $providerUser->getId(),
                'token' => $providerUser->token,
                'tokenSecret' => $providerUser->tokenSecret,
            ]);
        }
    }

    public function registerProviderUser(Request $request, string $provider)
    {
        //google
        if ($provider === 'google') {
            $request->validate([
                'name' => ['required', 'string', 'min:1', 'max:15', 'unique:users'],
                'token' => ['required', 'string'],
            ]);

            //twitter
        } elseif ($provider === 'twitter') {
            $request->validate([
                'name' => ['required', 'string', 'min:1', 'max:15', 'unique:users'],
                'token' => ['required', 'string'],
                'tokenSecret' => ['required', 'string'],
            ]);
        }

        $token = $request->token;

        $providerUser = Socialite::driver($provider);

        //google
        if ($provider === 'google') {
            $providerUser = $providerUser->userFromToken($token);

            //twitter
        } elseif ($provider === 'twitter') {
            $tokenSecret = $request->tokenSecret;
            $providerUser = $providerUser->userFromTokenAndSecret($token, $tokenSecret);
        }

        //google
        if ($provider === 'google') {
            $user = User::create([
                'name' => $request->name,
                'email' => $providerUser->getEmail(),
                'password' => null,
            ]);

            //twitter
        } elseif ($provider === 'twitter') {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'twitter_id' => $providerUser->getId(),
                'password' => null,
            ]);
        }

        $this->guard()->login($user, true);

        return $this->registered($request, $user)
        ?: redirect($this->redirectPath());
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }
}
