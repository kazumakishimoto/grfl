<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

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

    // ゲストユーザー用のユーザーIDを定数として定義
    private const GUEST_USER_ID = 1;

    // ゲストログイン処理
    public function guestLogin()
    {
        // id=1 のゲストユーザー情報がDBに存在すれば、ゲストログインする
        if (Auth::loginUsingId(self::GUEST_USER_ID)) {
            return redirect('/');
        }

        return redirect('/');
    }

    //SNS認証ページへユーザーをリダイレクト
    public function redirectToProvider(string $provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    //ログイン
    public function handleProviderCallback(Request $request, string $provider)
    {
        //認証結果の受け取り
        $providerUser = Socialite::driver($provider)->user();

        //Google
        if ($provider === 'google') {
            //Googleから取得したユーザー情報からメールアドレスを取得
            $user = User::where('email', $providerUser->getEmail())->first();

            //Twitter
        } elseif ($provider === 'twitter') {
            //Twitterから取得したユーザー情報からユーザーIDを取得
            $user = User::where('twitter_id', $providerUser->getId())->first();
        }

        //ログイン処理
        if ($user) {
            $this->guard()->login($user, true);
            return $this->sendLoginResponse($request);
        }

        //Google
        if ($provider === 'google') {

            $data = [
                'provider' => $provider,
                'email' => $providerUser->getEmail(),
                'token' => $providerUser->token,
            ];

            return redirect()->route('register.{provider}', $data);

            //Twitter
        } elseif ($provider === 'twitter') {

            $data = [
                'provider' => $provider,
                'twitter_id' => $providerUser->getId(),
                'token' => $providerUser->token,
                'tokenSecret' => $providerUser->tokenSecret,
            ];
            //DBにユーザー情報がなければ作成する
            return redirect()->route('register.{provider}', $data);
        }
    }
}
