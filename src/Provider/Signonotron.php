<?php
namespace rlafferty05\OAuth2\Client\Provider;
use \League\OAuth2\Client\Provider\AbstractProvider;
use \League\OAuth2\Client\Entity\User;
use \League\OAuth2\Client\Token\AccessToken;
class Signonotron extends AbstractProvider {
  // Coinbase uses a different scope separator
    public $scopeSeparator = ' ';
    public $ini = parse_ini_file('signonotron.ini');

    public function urlAuthorize() {
        return $ini['authorize_url'];
    }

    public function urlAccessToken() {
        return $ini['access_token_url'];
    }

    public function urlUserDetails(AccessToken $token) {
        return $ini['access_token_url'] . urlencode($token);
    }

    public function userDetails($response, AccessToken $token) {
        $user = new User;
        $user->uid = $response->uid;
        $user->name = $response->display_name;
        $user->email = $response->email;
        return $user;
    }
}