<?php

namespace Kinde\KindeSDK\Sdk\OAuth2;

use Kinde\KindeSDK\Sdk\Utils\Utils;
use Kinde\KindeSDK\KindeClientSDK;

class PKCE
{
    /**
     * It generates a code challenge and code verifier, stores the code verifier in the cache, and
     * redirects the user to the authorization endpoint with the code challenge and other parameters
     * 
     * @param string clientId The client ID of your application.
     * @param string clientSecret The client secret of your application.
     * @param string redirectUri The redirect URI that you specified in the app settings.
     * @param string authorizationEndpoint The URL of the authorization endpoint.
     * @param string scopes The scopes you want to request.
     * @param string state This is an optional parameter that you can use to pass a value to the
     * authorization server. The authorization server will return this value to you in the response.
     * 
     * @return A redirect to the authorization endpoint with the parameters needed to start the
     * authorization process.
     */
    public function login(KindeClientSDK $clientSDK, string $startPage = 'login', array $additionalParameters = [])
    {
        $_SESSION['kinde']['oauthCodeVerifier'] = '';
        $challenge = Utils::generateChallenge();
        $state = $challenge['state'];
        $_SESSION['kinde']['oauthState'] = $state;
        $searchParams = [
            'redirect_uri' => $clientSDK->redirectUri,
            'client_id' => $clientSDK->clientId,
            'response_type' => 'code',
            'scope' => $clientSDK->scopes,
            'code_challenge' => $challenge['codeChallenge'],
            'code_challenge_method' => 'S256',
            'state' => $state,
            'start_page' => $startPage
        ];
        $mergedAdditionalParameters = Utils::addAdditionalParameters($clientSDK->additionalParameters, $additionalParameters);
        $searchParams = array_merge($searchParams, $mergedAdditionalParameters);
        $_SESSION['kinde']['oauthCodeVerifier'] =  $challenge['codeVerifier'];

        if (!headers_sent()) {
            exit(header('Location: ' . $clientSDK->authorizationEndpoint . '?' . http_build_query($searchParams)));
        }
    }
}
