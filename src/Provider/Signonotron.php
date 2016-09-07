<?php
namespace Learningpool\OAuth2\Client\Provider;
use \League\OAuth2\Client\Provider\AbstractProvider;
use \League\OAuth2\Client\Entity\User;
use \League\OAuth2\Client\Token\AccessToken;

class Signonotron extends AbstractProvider {
    public $ini;

    public function __construct($options = []) {
        parent::__construct($options);
        $this->ini = parse_ini_file('signonotron.ini');
    }

    public function urlAuthorize() {
        return $this->ini['authorize_url'];
    }

    public function urlAccessToken() {
        return $this->ini['access_token_url'];
    }

    public function urlUserDetails(AccessToken $token) {
        return $this->ini['access_token_url'] . urlencode($token);
    }

    public function userDetails($response, AccessToken $token) {
        $user = new User;
        $user->uid = $response->uid;
        $user->name = $response->name;
        $user->email = $response->email;
        return $user;
    }
}
