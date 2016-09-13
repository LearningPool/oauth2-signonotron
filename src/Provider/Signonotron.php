<?php
namespace Learningpool\OAuth2\Client\Provider;
use \League\OAuth2\Client\Provider\AbstractProvider;
use \League\OAuth2\Client\Entity\User;
use \League\OAuth2\Client\Token\AccessToken;

class Signonotron extends AbstractProvider {
    public $ini;

    public function urlAuthorize() {
        return $this->ini['site_url'] . "/oauth/authorize";
    }
    public function urlAccessToken(array $params) {
        return $this->ini['site_url'] . "/oauth/token";
    }
    public function urlUserDetails(AccessToken $token) {
        return $this->ini['site_url'] . "/user.json?access_token=" . urlencode($token);
    }
    protected function getDefaultScopes() {
        return $this->defaultScopes;
    }
    protected function checkResponse(ResponseInterface $response, $data) {
        if (!empty($data['error'])) {
            throw new IdentityProviderException($data['error_description'], $response->getStatusCode(), $response);
        }
    }
    protected function createResourceOwner(array $response, AccessToken $token) {
        return new SignonotronResourceOwner($response);
    }

    public function __construct($options = []) {
        parent::__construct($options);
        $this->ini = parse_ini_file('signonotron.ini');
    }

    public function userDetails($response, AccessToken $token) {
        $user = new User();
        $user->uid = $response->user->uid;
        $user->name = $response->user->name;
        $user->email = $response->user->email;

        return $user;
    }
}
