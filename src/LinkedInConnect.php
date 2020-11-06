<?php


namespace Puviz\LinkedInConnect;

use GuzzleHttp\Client;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use \Puviz\LinkedInConnect\Contracts\LinkedInConnect as LinkedInConnectContract;
use Puviz\LinkedInConnect\Models\LinkedInToken;

class LinkedInConnect implements LinkedInConnectContract
{

    /**
     * The scopes being requested.
     *
     * @var array
     */
    protected $scopes = ['r_liteprofile', 'r_emailaddress', 'w_member_social'];

    /**
     * The type of the encoding in the query.
     *
     * @var int Can be either PHP_QUERY_RFC3986 or PHP_QUERY_RFC1738.
     */
    protected $encodingType = PHP_QUERY_RFC1738;


    public function redirect()
    {
        $url = 'https://www.linkedin.com/oauth/v2/authorization';
        $config = config('linkedin.linkedin_access_client');

        $fields = [
            'client_id' => $config['client_id'],
            'redirect_uri' => $config['redirect'],
            'scope' => implode(' ', $this->scopes),
            'response_type' => 'code',
            'state' => ''
        ];

        return new RedirectResponse($url . '?' . http_build_query($fields, '', '&', $this->encodingType));
    }

    public function tokenFromCallback()
    {
        $request = request();
        $url = 'https://www.linkedin.com/oauth/v2/accessToken';
        $config = config('linkedin.linkedin_access_client');

        if (!Auth::check()) {
            abort(403, 'Only authenticated users can connect new linkedin user.');
        }
        $authUserId = Auth::id();

        $tokenFields = [
            'grant_type' => 'authorization_code',
            'client_id' => $config['client_id'],
            'client_secret' => $config['client_secret'],
            'code' => $request->input('code'),
            'redirect_uri' => $config['redirect'],
        ];

        $response = $this->getHttpClient()->post($url, [
            'headers' => ['Accept' => 'application/json', 'Content-Type' => 'application/x-www-form-urlencoded'],
            'form_params' => $tokenFields,
        ]);

        $body = (array)json_decode($response->getBody(), true);
        $basicProfile = $this->getBasicProfile(Arr::get($body, 'access_token'));

        return LinkedInToken::create([
            'user_id' => $authUserId,
            'account_id' => Arr::get($basicProfile, 'access_token'),
            'access_token' => Arr::get($body, 'access_token'),
            'expires_in' => Arr::get($body, 'expires_in'),
            'refresh_token' => null,
        ]);

    }

    public function isUserAuthorized($userId)
    {
        // TODO: Implement isUserAuthorized() method.
    }

    public function postJob($userId, $values, $accountId = null)
    {
        // TODO: Implement postJob() method.
    }

    private function createLinkInClient()
    {
        // TODO: Implement postJob() method.
    }

    /**
     * Get a instance of the Guzzle HTTP client.
     *
     * @return \GuzzleHttp\Client
     */
    private function getHttpClient()
    {
        return new Client();
    }


    /**
     * Get the basic profile fields for the user.
     *
     * @param string $token
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    private function getBasicProfile(string $token)
    {
        $url = 'https://api.linkedin.com/v2/me?projection=(id,firstName,lastName,profilePicture(displayImage~:playableStreams))';

        $response = $this->getHttpClient()->get($url, [
            'headers' => [
                'Authorization' => 'Bearer ' . $token,
                'X-RestLi-Protocol-Version' => '2.0.0',
            ],
        ]);

        return (array)json_decode($response->getBody(), true);
    }
}
