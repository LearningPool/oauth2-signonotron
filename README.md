# Sign-On-O-Tron Provider for OAuth 2.0 Client

[![Build Status](https://travis-ci.org/rlafferty05/oauth2-signonotron.svg?branch=master)](https://travis-ci.org/rlafferty05/oauth2-signonotron)
[![Latest Stable Version](https://poser.pugx.org/rlafferty05/oauth2-signonotron/v/stable.svg)](https://packagist.org/packages/rlafferty05/oauth2-signonotron)

This package provides Sign-On-O-Tron OAuth 2.0 support for the PHP League's [OAuth 2.0 Client](https://github.com/thephpleague/oauth2-client).

## Installation

To install, use composer:

```
composer require rlafferty05/oauth2-signonotron
```

## Usage

Usage is the same as The League's OAuth client, using `\Learningpool\OAuth2\Client\Provider\Signonotron` as the provider.

### Authorization Code Flow

```php
$provider = new Learningpool\OAuth2\Client\Provider\Signonotron([
    'clientId'          => '{signonotron-client-id}',
    'clientSecret'      => '{signonotron-client-secret}',
    'redirectUri'       => 'https://example.com/callback-url'
]);

if (!isset($_GET['code'])) {

    // If we don't have an authorization code then get one
    $authUrl = $provider->getAuthorizationUrl();
    $_SESSION['oauth2state'] = $provider->state;
    header('Location: '.$authUrl);
    exit;

// Check given state against previously stored one to mitigate CSRF attack
} elseif (empty($_GET['state']) || ($_GET['state'] !== $_SESSION['oauth2state'])) {

    unset($_SESSION['oauth2state']);
    exit('Invalid state');

} else {

    // Try to get an access token (using the authorization code grant)
    $token = $provider->getAccessToken('authorization_code', [
        'code' => $_GET['code']
    ]);

    // Optional: Now you have a token you can look up a users profile data
    try {

        // We got an access token, let's now get the user's details
        $userDetails = $provider->getUserDetails($token);

        // Use these details to create a new profile
        printf('Hello %s!', $userDetails->name);

    } catch (Exception $e) {

        // Failed to get user details
        exit('Oh dear...');
    }

    // Use this to interact with an API on the users behalf
    echo $token->accessToken;
}
```

## License

The MIT License (MIT). Please see [License File](https://github.com/rlafferty05/oauth2-signonotron/LICENSE) for more information.