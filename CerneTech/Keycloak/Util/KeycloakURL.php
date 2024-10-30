<?php

namespace CerneTech\Keycloak\Util;

class KeycloakURL
{
    private const KEYCLOAK_BASE_URL = '%s/realms/%s';
    private const KEYCLOAK_ADMIN_BASE_URL = '%s/admin/realms/%s';
    private const KEYCLOAK_PROTOCOL = '/protocol/openid-connect';
    private const KEYCLOAK_ADMIN_USERS = '/users';

    public static function parse(string $template, array $parameter): string
    {
        return vsprintf($template, $parameter);
    }

    // Session/Account
    public static function login(array $parameter): string
    {
        $url = self::KEYCLOAK_BASE_URL . self::KEYCLOAK_PROTOCOL . '/token';
        return self::parse($url, $parameter);
    }

    public static function logout(array $parameter): string
    {
        $url = self::KEYCLOAK_BASE_URL . self::KEYCLOAK_PROTOCOL . '/logout';
        return self::parse($url, $parameter);
    }

    public static function validateToken(array $parameter): string
    {
        $url = self::KEYCLOAK_BASE_URL . self::KEYCLOAK_PROTOCOL . '/token' . '/introspect';
        return self::parse($url, $parameter);
    }

    public static function refreshToken(array $parameter)
    {
        $url = self::KEYCLOAK_BASE_URL . self::KEYCLOAK_PROTOCOL . '/token';
        return self::parse($url, $parameter);
    }

    public static function resetPassword(array $parameter): string
    {
        $url = self::KEYCLOAK_ADMIN_BASE_URL . self::KEYCLOAK_ADMIN_USERS . '/%s/reset-password';
        return self::parse($url, $parameter);
    }

    // Users
    public static function userCreate(array $parameter): string
    {
        $url = self::KEYCLOAK_ADMIN_BASE_URL . self::KEYCLOAK_ADMIN_USERS;
        return self::parse($url, $parameter);
    }

    public static function userFilterById(array $parameter)
    {
        $url = self::KEYCLOAK_ADMIN_BASE_URL . self::KEYCLOAK_ADMIN_USERS . '/%s';
        return self::parse($url, $parameter);
    }
    public static function userFilter(array $parameter, array $filter)
    {
        $queryString = http_build_query($filter);
        $url = self::KEYCLOAK_ADMIN_BASE_URL . self::KEYCLOAK_ADMIN_USERS;
        return self::parse($url, $parameter) . '?' . $queryString;
    }

    public static function userUpdate(array $parameter)
    {
        $url = self::KEYCLOAK_ADMIN_BASE_URL . self::KEYCLOAK_ADMIN_USERS . '/%s';
        return self::parse($url, $parameter);
    }

    public static function userDelete(array $parameter): string
    {
        $url = self::KEYCLOAK_ADMIN_BASE_URL . self::KEYCLOAK_ADMIN_USERS . '/%s';
        return self::parse($url, $parameter);
    }

    // Roles
    public static function userRoles(array $parameter)
    {
        $url = self::KEYCLOAK_ADMIN_BASE_URL . self::KEYCLOAK_ADMIN_USERS . '/%s/role-mappings';
        return self::parse($url, $parameter);
    }

    public static function addUserRole(array $parameter)
    {
        $url = self::KEYCLOAK_ADMIN_BASE_URL . self::KEYCLOAK_ADMIN_USERS . '/%s/role-mappings/realm';
        return self::parse($url, $parameter);
    }

    public static function removeUserRole(array $parameter)
    {
        $url = self::KEYCLOAK_ADMIN_BASE_URL . self::KEYCLOAK_ADMIN_USERS . '/%s/role-mappings/realm';
        return self::parse($url, $parameter);
    }

    // Administrativo
    public static function getCerts(array $parameter)
    {
        $url = self::KEYCLOAK_BASE_URL . self::KEYCLOAK_PROTOCOL . '/certs';
        return self::parse($url, $parameter);
    }
}
