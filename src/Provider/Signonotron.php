<?php
namespace Learningpool\OAuth2\Client\Provider;
use \League\OAuth2\Client\Provider\AbstractProvider;
use \League\OAuth2\Client\Entity\User;
use \League\OAuth2\Client\Token\AccessToken;

class Signonotron extends AbstractProvider {
    public $ini;

    public function getBaseAuthorizationUrl() {
        return $this->ini['authorize_url'];
    }
    public function getBaseAccessTokenUrl(array $params) {
        return $this->ini['access_token_url'];
    }
    public function getResourceOwnerDetailsUrl(AccessToken $token) {
        return $this->ini['access_token_url'] . "?token=" . urlencode($token);
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
        $user = new User;
        $user->uid = $response->uid;
        $user->name = $response->name;
        $user->email = $response->email;
        return $user;
    }
}
