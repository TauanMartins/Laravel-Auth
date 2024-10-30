<?php

namespace CerneTech\Keycloak\Model;

class KeycloakUserParameters
{
    private $parameters = [];

    private function __construct(string $key, $value)
    {
        $this->parameters[$key] = $value;
    }

    public static function USERNAME(string $username): self
    {
        return new self('username', $username);
    }

    public static function EMAIL(string $email): self
    {
        return new self('email', $email);
    }

    public static function FIRST_NAME(string $firstName): self
    {
        return new self('firstName', $firstName);
    }

    public static function LAST_NAME(string $lastName): self
    {
        return new self('lastName', $lastName);
    }

    public static function REQUIRED_ACTIONS(): self
    {
        return new self('requiredActions', []);
    }

    public function VERIFY_EMAIL(): self
    {
        $this->parameters['requiredActions'][] = 'VERIFY_EMAIL';
        return $this;
    }

    public function CONFIGURE_TOTP(): self
    {
        $this->parameters['requiredActions'][] = 'CONFIGURE_TOTP';
        return $this;
    }

    public function toArray(): array
    {
        return $this->parameters;
    }
}

