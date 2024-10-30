<?php

namespace CerneTech\Keycloak\Interface;

use CerneTech\Keycloak\Model\KeycloakToken;
use CerneTech\Keycloak\Model\KeycloakUser;

interface KeycloakInterface
{
    public function login(array $credentials): KeycloakToken;

    public function logout(string $refreshToken, string $idToken);

    public function refreshToken(string $refreshToken): KeycloakToken;

    public function validateToken(string $access);

    public function createUser(KeycloakUser $user);

    public function deleteUser(string $uuid);

    public function activateUser(string $uuid);

    public function resetUserPassword(string $uuid, string $password);

    /**
     * Utilizar classe KeycloakUserFilters para definir os parâmetros. 
     * Exemplo 1:
     * $filters = [
     *      KeycloakUserFilters::USERNAME('username'),
     *      KeycloakUserFilters::EMAIL('email@locroom.com'),
     * ];
     * $this->keycloakFactory->getUser($parameters);
     * Exemplo 2:
     * $filters = [
     *      KeycloakUserFilters::UUID('uuid')
     * ];
     * $this->keycloakFactory->getUser($parameters, true);
     */
    public function getUser(array $parameters, bool $byId=false);

    /**
     * Utilizar classe KeycloakUserParameters para definir os parâmetros. Exemplo:
     * $uuid= 'uuid';
     * $parameters = [
     *      KeycloakUserParameters::USERNAME('username'),
     *      KeycloakUserParameters::EMAIL('email@locroom.com'),
     *      KeycloakUserParameters::FIRST_NAME('firstName'),
     *      KeycloakUserParameters::LAST_NAME('lastName'),
     *      KeycloakUserParameters::REQUIRED_ACTIONS()->VERIFY_EMAIL()->CONFIGURE_TOTP()
     * ];
     * $this->keycloakFactory->updateUser($uuid, $parameters);
     */
    public function updateUser(string $uuid, array $parameters);

    // abaixo métodos não desenvolvidos ainda
    public function getUserRoles(string $uuid);

    public function addUserRole(string $uuid, string $role);

    public function removeUserRole(string $uuid, string $role);
}
