<?php

namespace App\Http\Controllers;

use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
class OAuthController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('github')->redirect();
    }

    public function callback()
{
    $githubUser = Socialite::driver('github')->user();
    $user = User::where('email', $githubUser->getEmail())->first();
    
    if (!$user) {
    $user = User::create([
        'name' => $githubUser->getName() ?? $githubUser->getNickname(),
        'email' => $githubUser->getEmail(),
        'password' => bcrypt(str()->random(32)),
    ]);
}
    $token = $user->createToken('auth_token')->plainTextToken;

    return view('oauth-success', [
    'token' => $token
]);
   
}


}