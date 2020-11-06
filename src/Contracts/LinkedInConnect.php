<?php

namespace Puviz\LinkedInConnect\Contracts;

interface LinkedInConnect
{
    /**
     * Redirect the user to the authentication page for the linkedin.
     *
     * @return mixed
     */
    public function redirect();

    /**
     * Get the linkedin's User instance for the authenticated user.
     *
     * @return mixed
     */
    public function tokenFromCallback();

    public function isUserAuthorized($userId);

    public function postJob($userId, $values, $accountId = null);

}
