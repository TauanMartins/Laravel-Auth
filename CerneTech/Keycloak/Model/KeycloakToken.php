<?php

namespace CerneTech\Keycloak\Model;

use Firebase\JWT\JWT;
use Firebase\JWT\JWK;
use CerneTech\Keycloak\Gateway\KeycloakHTTP;
use CerneTech\Keycloak\Util\KeycloakInfo;
use CerneTech\Keycloak\Util\KeycloakURL;

class KeycloakToken
{
    private string $accessToken;
    private int $expiresIn;
    private string $refreshToken;
    private int $refreshExpiresIn;
    private string $tokenType;
    private string $idToken;
    private int $notBeforePolicy;
    private array $scope;

    public function __construct(
        $accessToken,
        $expiresIn,
        $refreshToken,
        $refreshExpiresIn,
        $tokenType,
        $idToken,
        $notBeforePolicy,
        $scope
    ) {
        $this->accessToken = $accessToken;
        $this->expiresIn = $expiresIn;
        $this->refreshToken = $refreshToken;
        $this->refreshExpiresIn = $refreshExpiresIn;
        $this->tokenType = $tokenType;
        $this->idToken = $idToken;
        $this->notBeforePolicy = $notBeforePolicy;
        $this->scope = explode(' ', $scope);
    }

    public function accessToken(): string
    {
        return $this->accessToken;
    }
    public function expiresIn(): int
    {
        return $this->expiresIn;
    }
    public function refreshToken(): string
    {
        return $this->refreshToken;
    }

    public function refreshExpiresIn(): int
    {
        return $this->refreshExpiresIn;
    }
    public function tokenType(): string
    {
        return $this->tokenType;
    }
    public function idToken(): string
    {
        return $this->idToken;
    }

    public function notBeforePolicy(): int
    {
        return $this->notBeforePolicy;
    }

    public function scope(): array
    {
        return $this->scope;
    }

    public function parse(): KeycloakDecodedToken
    {
        $jwks = KeycloakHTTP::get(KeycloakURL::getCerts([KeycloakInfo::hostname(), KeycloakInfo::realmName()]));
        $keys = json_decode($jwks->getBody(), true);

        // Converter as chaves JWK para um array utilizável pela biblioteca JWT
        $keyArray = JWK::parseKeySet($keys);

        // Decodificar o accessToken
        $decodedToken = JWT::decode($this->accessToken, $keyArray);

        $expirationTime = $decodedToken->exp;
        $issuedAt = $decodedToken->iat;
        $jwtId = $decodedToken->jti;
        $issuer = $decodedToken->iss;
        $audience = $decodedToken->aud ?? '';
        $subject = $decodedToken->sub;
        $tokenType = $decodedToken->typ;
        $authorizedParty = $decodedToken->azp;
        $sessionId = $decodedToken->session_state;
        $allowedOrigins = $decodedToken->{'allowed-origins'};
        $realmAccessRoles = $decodedToken->realm_access->roles;
        $resourceAccessRoles = $decodedToken->resource_access->account->roles ?? ['account' => ['roles' => []]];
        $scope = $decodedToken->scope;
        $sessionIdentifier = $decodedToken->sid;
        $emailVerified = $decodedToken->email_verified;
        $name = $decodedToken->name;
        $preferredUsername = $decodedToken->preferred_username;
        $givenName = $decodedToken->given_name;
        $familyName = $decodedToken->family_name;
        $email = $decodedToken->email;

        // Criar e retornar um objeto KeycloakDecodedToken com as informações extraídas
        return new KeycloakDecodedToken(
            $expirationTime,
            $issuedAt,
            $jwtId,
            $issuer,
            $audience,
            $subject,
            $tokenType,
            $authorizedParty,
            $sessionId,
            $allowedOrigins,
            $realmAccessRoles,
            $resourceAccessRoles,
            $scope,
            $sessionIdentifier,
            $emailVerified,
            $name,
            $preferredUsername,
            $givenName,
            $familyName,
            $email
        );
    }

    public function toArray()
    {
        return [
            'access_token' => $this->accessToken,
            'expires_in' => $this->expiresIn,
            'refresh_token' => $this->refreshToken,
            'refresh_expires_in' => $this->refreshExpiresIn,
            'token_type' => $this->tokenType,
            'id_token' => $this->idToken,
            'not-before-policy' => $this->notBeforePolicy,
            'scope' => implode(' ', $this->scope)
        ];
    }
}