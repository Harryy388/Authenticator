<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PragmaRX\Google2FA\Google2FA;


class MfaController extends Controller
{


    public function setup(Request $request)
    {
        // haalt de huidige ingelogde gebruiker op
        $user = $request->user();

        // maakt een nieuwe instantie van de Google2FA-bibliotheek
        $google2fa = new Google2FA();

        // genereert een nieuwe MFA-secret voor de gebruiker
        $secret = $google2fa->generateSecretKey();

        // slaat de gegenereerde MFA-secret op in de database
        $user->mfa_secret = $secret;

        // slaat wijzigingen op in de database
        $user->save();

        //naam in authenticator app 
        $otpauthUrl = $google2fa->getQRCodeUrl(
            'Authenticator Project',
            // de naam van de gebruiker of e-mailadres
            $user->email,
            // de gegenereerde MFA-secret
            $secret
        );



        //stuurt Json response voor postman
        return response()->json([
            'message' => 'MFA setup aangemaakt',
            'otpauth_url' => $otpauthUrl

        ]);
    }
    public function verify(Request $request)
    {
        $request->validate([
            'code' => 'required|string',
        ]);

        $user = $request->user();

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
        
        $user->mfa_enabled = true;
        $user->save();
        
        return response()->json([
            'message' => 'MFA verificatie gelukt'
        ]);
    }
}
