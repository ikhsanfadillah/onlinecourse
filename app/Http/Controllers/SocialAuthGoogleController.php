<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Socialite;
use Auth;
use Exception;



class SocialAuthGoogleController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }


    public function callback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            $existUser = User::where('email',$googleUser->email)->first();

            if($existUser) {
                Auth::loginUsingId($existUser->id);
            }
            else {
                $user = new User;
                $user->name = $googleUser->name;
                $user->email = $googleUser->email;
                $user->google_id = $googleUser->id;
                $user->password = bcrypt(rand(1,99999));
                $user->save();

                $user->assignRole('student');
                Auth::loginUsingId($user->id);
            }
            return redirect()->route('landingpage');
        }
        catch (Exception $e) {
            return $e;
        }
    }
}