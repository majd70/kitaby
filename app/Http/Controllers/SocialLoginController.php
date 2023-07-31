<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use App\Http\Controllers\Controller;
use App\Models\User;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;
use Throwable;

class SocialLoginController extends Controller
{

    public function redirect($provider)
    {
        /*
        return Socialite::driver($provider)
          ->with(['prompt' => 'select_account'])
      ->redirect();
      */
        return Socialite::driver($provider)->redirect();
    }

    public function callback($provider)
    {
        try {
            $provider_user = Socialite::driver($provider)->user();
            //dd($provider_user);

            $user = User::where([
                'provider' => $provider,
                'provider_id' => $provider_user->id
            ])->first();

            if (!$user) {
                $user = User::create([
                    'name' => $provider_user->name,
                    'email' => $provider_user->email,
                    'provider' => $provider,
                    'provider_id' => $provider_user->id,
                    'provider_token' => $provider_user->token,
                ]);
            }
            // create profile for user
            if ($user->profile == null) {
                $user->profile()->create([
                    'user_id' => $user->id,
                ]);
            }

            Auth::login($user);
            // Redirect based on user type
            if ($user->type === 'super-admin') {
                return redirect()->route('categories.index');
            } else {
                return redirect()->route('home');
            }
        } catch (Throwable $e) {
            return redirect()->route('login')->withErrors([
                'email' => $e->getMessage(),
            ]);
        }
    }
    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }




    /*public function callback($provider)
{
    try {
        $provider_user = Socialite::driver($provider)->user();
        dd($provider_user);
        // ...

    } catch (Throwable $e) {
        // Log the exception
        logger()->error('Social login error', ['exception' => $e]);

        return redirect()->route('login')->withErrors([
            'email' => $e->getMessage(),
        ]);
    }
    */
}
