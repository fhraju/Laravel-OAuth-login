<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use PhpParser\Node\Scalar\MagicConst\Function_;

class GoogleController extends Controller
{
    // Redirect
    public function loginWithGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    // Callback
    public function callbackFromGoogle()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            
            // Checking if the users already in database
            $is_user = User::where('email', $googleUser->getEmail())->first();
            if (!$is_user)
            {
                $saveUser = User::updateOrCreate([
                    'google_id' => $googleUser->getId(),
                ], [
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'password' => bcrypt($googleUser->getName(). '$' . $googleUser->getId()),
                ]);
            }else
            {
                $saveUser = User::where('email', $googleUser->getEmail())->update([
                    'google_id' => $googleUser->getId(),
                ]);
            }


            Auth::loginUsingId($saveUser->id);

            return redirect()->route('home');


        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
