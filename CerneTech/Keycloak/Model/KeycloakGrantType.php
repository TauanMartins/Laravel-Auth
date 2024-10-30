<?php

namespace CerneTech\Keycloak\Model;

class KeycloakGrantType
{
    const PASSWORD = 'password';
    const REFRESH_TOKEN = 'refresh_token';
    const AUTHORIZATION_CODE = 'authorization_code';
    const CLIENT_CREDENTIALS = 'client_credentials';
    const IMPLICIT = 'implicit';

    public static function password()
    {
        return self::PASSWORD;
    }

    public static function refreshToken()
    {
        return self::REFRESH_TOKEN;
    }

    public static function authorizationCode()
    {
        return self::AUTHORIZATION_CODE;
    }

    public static function clientCredentials()
    {
        return self::CLIENT_CREDENTIALS;
    }

    public static function implicit()
    {
        return self::IMPLICIT;
    }
}
