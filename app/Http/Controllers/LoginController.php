<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use PragmaRX\Google2FA\Google2FA;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'code' => 'nullable|string',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Ongeldige inloggegevens'
            ], 401);
        }

        if ($user->mfa_enabled) {
            if (!$request->code) {
                return response()->json([
                    'message' => 'MFA vereist',
                    'mfa_required' => true
                ]);
            }

            $google2fa = new Google2FA();

            $isValid = $google2fa->verifyKey(
                $user->mfa_secret,
                $request->code
            );

            if (!$isValid) {
                return response()->json([
                    'message' => 'Ongeldige MFA-code'
                ], 401);
            }
        }



        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Login gelukt',
            'user' => $user,
            'token' => $token
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'message' => 'Uitgelogd'
        ]);
    }
}
