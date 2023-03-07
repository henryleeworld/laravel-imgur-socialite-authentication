<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Auth;
use Exception;
use Socialite;
  
class ImgurController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function redirectToImgur()
    {
        return Socialite::driver('imgur')->redirect();
    }
      
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function handleImgurCallback()
    {
        try {
            $imgurUser = Socialite::driver('imgur')->user();
            $user = User::updateOrCreate([
                'imgur_id'       => $imgurUser->id,
            ], [
                'name'           => $imgurUser->name,
                'email'          => $imgurUser->email,
                'password'       => encrypt('123456dummy'),
                'imgur_nickname' => $imgurUser->nickname,
            ]);
            Auth::login($user);
            return redirect('/dashboard');
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }
}

