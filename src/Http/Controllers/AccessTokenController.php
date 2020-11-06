<?php

namespace Puviz\LinkedInConnect\Http\Controllers;


use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Puviz\LinkedInConnect\Facades\LinkedInConnect;
use Puviz\LinkedInConnect\Models\LinkedInToken;

class AccessTokenController extends Controller
{

    public function redirectToProvider()
    {
        return LinkedInConnect::driver('linkedin')->redirect();
    }

    /**
     * Obtain the user information from Linkedin.
     *
     * @return RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function handleProviderCallback()
    {
        if (! Auth::check()) {
            abort (403, 'Only authenticated users can connect new linkedin user.');
        }

        $user = LinkedInConnect::driver('linkedin')->user();
        $authUserId = Auth::id();

        LinkedInToken::create([
            'user_id' => $authUserId,
            'account_id' => $user->id,
            'access_token' => $user->token,
            'expires_in' => $user->expiresIn,
            'refresh_token' => $user->refreshToken,
        ]);

        return redirect('/');
    }
}
