<?php

namespace CerneTech\Keycloak\Factory;

use CerneTech\Keycloak\Interface\KeycloakInterface;
use CerneTech\Keycloak\Util\KeycloakInfo;
use CerneTech\Keycloak\Service\KeycloakService;

class KeycloakFactory
{
    public static function confidential(): KeycloakInterface
    {
        return new KeycloakService(['client_id' => KeycloakInfo::clientId(), 'client_secret' => KeycloakInfo::clientSecret()]);
    }
    public static function public(): KeycloakInterface
    {
        return new KeycloakService([]);
    }
    public static function bearerOnly(): KeycloakInterface
    {
        return new KeycloakService(['client_id' => KeycloakInfo::clientId()]);
    }
}
