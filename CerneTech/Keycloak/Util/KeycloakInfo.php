<?php

namespace CerneTech\Keycloak\Util;

class KeycloakInfo
{
    public static function realmName()
    {
        return env('KEYCLOAK_REALM_NAME');
    }

    public static function hostname()
    {
        return env('KEYCLOAK_HOST');
    }

    public static function clientId()
    {
        return env('KEYCLOAK_CLIENT_ID');
    }

    public static function clientSecret()
    {
        return env('KEYCLOAK_CLIENT_SECRET');
    }

}
