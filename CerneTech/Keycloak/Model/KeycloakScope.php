<?php

namespace CerneTech\Keycloak\Model;

class KeycloakScope
{
    const OPENID = 'openid';
    const EMAIL = 'email';
    const PROFILE = 'profile';
    const PHONE = 'phone';

    public static function openid()
    {
        return self::OPENID;
    }
    public static function email()
    {
        return self::EMAIL;
    }
    public static function profile()
    {
        return self::PROFILE;
    }
    public static function phone()
    {
        return self::PHONE;
    }
}
