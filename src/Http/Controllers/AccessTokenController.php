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
        return LinkedInConnect::redirect();
    }

    /**
     * Obtain the user information from Linkedin.
     *
     * @return RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function handleProviderCallback()
    {
        LinkedInConnect::tokenFromCallback();
        return redirect('/');
    }
}
