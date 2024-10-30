<?php

namespace CerneTech\Keycloak\Model;

class KeycloakDecodedToken
{
    private int $expirationTime;
    private int $issuedAt;
    private string $jwtId;
    private string $issuer;
    private string $audience;
    private string $subject;
    private string $tokenType;
    private string $authorizedParty;
    private string $sessionId;
    private array $allowedOrigins;
    private array $realmAccessRoles;
    private array $resourceAccessRoles;
    private string $scope;
    private string $sessionIdentifier;
    private bool $emailVerified;
    private string $name;
    private string $preferredUsername;
    private string $givenName;
    private string $familyName;
    private string $email;

    public function __construct(
        int $expirationTime,
        int $issuedAt,
        string $jwtId,
        string $issuer,
        string $audience,
        string $subject,
        string $tokenType,
        string $authorizedParty,
        string $sessionId,
        array $allowedOrigins,
        array $realmAccessRoles,
        array $resourceAccessRoles,
        string $scope,
        string $sessionIdentifier,
        bool $emailVerified,
        string $name,
        string $preferredUsername,
        string $givenName,
        string $familyName,
        string $email
    ) {
        $this->expirationTime = $expirationTime;
        $this->issuedAt = $issuedAt;
        $this->jwtId = $jwtId;
        $this->issuer = $issuer;
        $this->audience = $audience;
        $this->subject = $subject;
        $this->tokenType = $tokenType;
        $this->authorizedParty = $authorizedParty;
        $this->sessionId = $sessionId;
        $this->allowedOrigins = $allowedOrigins;
        $this->realmAccessRoles = $realmAccessRoles;
        $this->resourceAccessRoles = $resourceAccessRoles;
        $this->scope = $scope;
        $this->sessionIdentifier = $sessionIdentifier;
        $this->emailVerified = $emailVerified;
        $this->name = $name;
        $this->preferredUsername = $preferredUsername;
        $this->givenName = $givenName;
        $this->familyName = $familyName;
        $this->email = $email;
    }

    public function getExpirationTime(): int
    {
        return $this->expirationTime;
    }

    public function getIssuedAt(): int
    {
        return $this->issuedAt;
    }

    public function getJwtId(): string
    {
        return $this->jwtId;
    }

    public function getIssuer(): string
    {
        return $this->issuer;
    }

    public function getAudience(): string
    {
        return $this->audience;
    }

    public function getSubject(): string
    {
        return $this->subject;
    }

    public function getTokenType(): string
    {
        return $this->tokenType;
    }

    public function getAuthorizedParty(): string
    {
        return $this->authorizedParty;
    }

    public function getSessionId(): string
    {
        return $this->sessionId;
    }

    public function getAllowedOrigins(): array
    {
        return $this->allowedOrigins;
    }

    public function getRealmAccessRoles(): array
    {
        return $this->realmAccessRoles;
    }

    public function getResourceAccessRoles(): array
    {
        return $this->resourceAccessRoles;
    }

    public function getScope(): string
    {
        return $this->scope;
    }

    public function getSessionIdentifier(): string
    {
        return $this->sessionIdentifier;
    }

    public function isEmailVerified(): bool
    {
        return $this->emailVerified;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPreferredUsername(): string
    {
        return $this->preferredUsername;
    }

    public function getGivenName(): string
    {
        return $this->givenName;
    }

    public function getFamilyName(): string
    {
        return $this->familyName;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function toArray(): array
    {
        return [
            'expiration_time' => $this->expirationTime,
            'issued_at' => $this->issuedAt,
            'jwt_id' => $this->jwtId,
            'issuer' => $this->issuer,
            'audience' => $this->audience,
            'subject' => $this->subject,
            'token_type' => $this->tokenType,
            'authorized_party' => $this->authorizedParty,
            'session_id' => $this->sessionId,
            'allowed_origins' => $this->allowedOrigins,
            'realm_access_roles' => $this->realmAccessRoles,
            'resource_access_roles' => $this->resourceAccessRoles,
            'scope' => $this->scope,
            'session_identifier' => $this->sessionIdentifier,
            'email_verified' => $this->emailVerified,
            'name' => $this->name,
            'preferred_username' => $this->preferredUsername,
            'given_name' => $this->givenName,
            'family_name' => $this->familyName,
            'email' => $this->email
        ];
    }
}
