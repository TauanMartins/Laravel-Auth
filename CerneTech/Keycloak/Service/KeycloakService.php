<?php

namespace CerneTech\Keycloak\Service;

use Exception;
use CerneTech\Keycloak\Interface\KeycloakInterface;
use CerneTech\Keycloak\Model\KeycloakUser;
use CerneTech\Keycloak\Util\KeycloakHTTPHeader;
use CerneTech\Keycloak\Model\KeycloakScope;
use CerneTech\Keycloak\Util\KeycloakURL;
use CerneTech\Keycloak\Gateway\KeycloakHTTP;
use CerneTech\Keycloak\Model\KeycloakGrantType;
use CerneTech\Keycloak\Util\KeycloakInfo;
use CerneTech\Keycloak\Model\KeycloakToken;

class KeycloakService implements KeycloakInterface
{
    private array $credentials;

    public function __construct(array $credentials)
    {
        $this->credentials = $credentials;
    }
    public function credentials(array $otherCredentials): array
    {
        return array_merge($this->credentials, $otherCredentials);
    }

    private function adminToken(): KeycloakToken
    {
        $credentials['grant_type'] = KeycloakGrantType::clientCredentials();
        $credentials['scope'] = implode(' ', [KeycloakScope::openid()]);
        $credentials = $this->credentials($credentials);
        $response = KeycloakHTTP::post(KeycloakURL::login([KeycloakInfo::hostname(), KeycloakInfo::realmName()]), $credentials);
        $responseParse = json_decode($response->getBody()->__toString());
        return new KeycloakToken(
            $responseParse->access_token,
            $responseParse->expires_in,
            '',
            $responseParse->refresh_expires_in,
            $responseParse->token_type,
            $responseParse->id_token,
            $responseParse->{'not-before-policy'},
            $responseParse->scope
        );
    }

    public function login(array $credentials): KeycloakToken
    {
        $credentials['grant_type'] = KeycloakGrantType::password();
        $credentials['scope'] = implode(' ', [KeycloakScope::openid()]);
        $credentials = $this->credentials($credentials);
        $response = KeycloakHTTP::post(KeycloakURL::login([KeycloakInfo::hostname(), KeycloakInfo::realmName()]), $credentials);
        $responseParse = json_decode($response->getBody()->__toString());
        return new KeycloakToken(
            $responseParse->access_token,
            $responseParse->expires_in,
            $responseParse->refresh_token,
            $responseParse->refresh_expires_in,
            $responseParse->token_type,
            $responseParse->id_token,
            $responseParse->{'not-before-policy'},
            $responseParse->scope
        );
    }
    public function logout(string $refreshToken, string $idToken)
    {
        $headers = new KeycloakHTTPHeader();
        $headers->setAuthorizationBearer($refreshToken);
        $credentials['id_token_hint'] = $idToken;
        $response = KeycloakHTTP::post(KeycloakURL::logout([KeycloakInfo::hostname(), KeycloakInfo::realmName()]), $credentials, $headers);
        return $response;
    }
    public function refreshToken(string $refreshToken): KeycloakToken
    {
        $credentials['grant_type'] = KeycloakGrantType::refreshToken();
        $credentials['refresh_token'] = $refreshToken;
        $credentials = $this->credentials($credentials);
        $response = KeycloakHTTP::post(KeycloakURL::refreshToken([KeycloakInfo::hostname(), KeycloakInfo::realmName()]), $credentials);
        $responseParse = json_decode($response->getBody()->__toString());
        return new KeycloakToken(
            $responseParse->access_token,
            $responseParse->expires_in,
            $responseParse->refresh_token,
            $responseParse->refresh_expires_in,
            $responseParse->token_type,
            $responseParse->id_token,
            $responseParse->{'not-before-policy'},
            $responseParse->scope
        );
    }
    public function validateToken(string $accessToken)
    {
        $headers = new KeycloakHTTPHeader();
        $headers->setAuthorizationBearer($accessToken);
        $credentials['token'] = $accessToken;
        $credentials['grant_type'] = KeycloakGrantType::clientCredentials();
        $credentials = $this->credentials($credentials);
        $response = KeycloakHTTP::post(KeycloakURL::validateToken([KeycloakInfo::hostname(), KeycloakInfo::realmName()]), $credentials, $headers);
        return json_decode($response->getBody()->__toString());
    }

    public function createUser(KeycloakUser $keycloakUser): string
    {
        $accessToken = $this->adminToken()->accessToken();
        $headers = new KeycloakHTTPHeader();
        $headers->setAuthorizationBearer($accessToken);
        $headers->setContentTypeApplicationJson();
        $response = KeycloakHTTP::post(KeycloakURL::userCreate([KeycloakInfo::hostname(), KeycloakInfo::realmName()]), $keycloakUser->toArray(), $headers);
        $location = $response->getHeaderLine('Location');
        $uuid = basename($location);
        return $uuid;
    }

    public function deleteUser(string $uuid)
    {
        $accessToken = $this->adminToken()->accessToken();
        $headers = new KeycloakHTTPHeader();
        $headers->setAuthorizationBearer($accessToken);
        $headers->setContentTypeApplicationJson();
        return KeycloakHTTP::delete(KeycloakURL::userDelete([KeycloakInfo::hostname(), KeycloakInfo::realmName(), $uuid]), $headers);
    }

    public function activateUser(string $uuid)
    {
        $accessToken = $this->adminToken()->accessToken();
        $headers = new KeycloakHTTPHeader();
        $headers->setAuthorizationBearer($accessToken);
        $headers->setContentTypeApplicationJson();
        $data = ['emailVerified' => true];
        return KeycloakHTTP::put(KeycloakURL::userUpdate([KeycloakInfo::hostname(), KeycloakInfo::realmName(), $uuid]), $data, $headers);
    }

    public function resetUserPassword(string $uuid, string $password)
    {
        $accessToken = $this->adminToken()->accessToken();
        $headers = new KeycloakHTTPHeader();
        $headers->setAuthorizationBearer($accessToken);
        $headers->setContentTypeApplicationJson();
        $data = ['type' => 'password', 'value' => $password, 'temporary' => false];
        return KeycloakHTTP::put(KeycloakURL::resetPassword([KeycloakInfo::hostname(), KeycloakInfo::realmName(), $uuid]), $data, $headers);
    }

    public function changeUserPassword(string $uuid, string $username, string $oldPassword, string $newPassword)
    {
        $credentials = ['username' => $username, 'password' => $oldPassword];
        $token = $this->login($credentials);
        if ($token) {
            $this->logout($token->refreshToken(), $token->idToken());
            $this->resetUserPassword($uuid, $newPassword);
            return true;
        }
        return false;
    }

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
    public function getUser(array $parameters, bool $byId = false)
    {
        $mergedFilters = [];
        foreach ($parameters as $filter) {
            $mergedFilters = array_merge($mergedFilters, $filter->toArray());
        }

        $accessToken = $this->adminToken()->accessToken();
        $headers = new KeycloakHTTPHeader();
        $headers->setAuthorizationBearer($accessToken);
        if ($byId) {
            $response = KeycloakHTTP::get(KeycloakURL::userFilterById([KeycloakInfo::hostname(), KeycloakInfo::realmName(), $mergedFilters['id']]), $headers);
        } else {
            $response = KeycloakHTTP::get(KeycloakURL::userFilter([KeycloakInfo::hostname(), KeycloakInfo::realmName()], $mergedFilters), $headers);

        }
        $user = json_decode($response->getBody()->__toString());
        if (!$user) {
            throw new Exception('user.not.exists');
        }
        return $byId ? $user : $user[0];
    }

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
    public function updateUser(string $uuid, array $parameters)
    {
        $mergedParameters = [];
        foreach ($parameters as $parameter) {
            $mergedParameters = array_merge($mergedParameters, $parameter->toArray());
        }
        $accessToken = $this->adminToken()->accessToken();
        $headers = new KeycloakHTTPHeader();
        $headers->setAuthorizationBearer($accessToken);
        $headers->setContentTypeApplicationJson();
        return KeycloakHTTP::put(KeycloakURL::userUpdate([KeycloakInfo::hostname(), KeycloakInfo::realmName(), $uuid]), $mergedParameters, $headers);
    }

    public function getUserRoles(string $uuid)
    {
        // Implementação do método getUserRoles
    }

    public function addUserRole(string $uuid, string $role)
    {
        // Implementação do método addUserRole
    }

    public function removeUserRole(string $uuid, string $role)
    {
        // Implementação do método removeUserRole
    }

}
