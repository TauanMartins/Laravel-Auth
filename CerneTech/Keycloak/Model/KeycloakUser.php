<?php

namespace CerneTech\Keycloak\Model;

class KeycloakUser
{
    private string $firstName;
    private string $lastName;
    private string $email;
    private string $username;
    private bool $enabled = true;
    private array $groups = [];
    private array $attributes = [];
    private bool $emailVerified = false;


    public function __construct(
        string $firstName,
        string $lastName,
        string $email,
        string $username
    ) {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->username = $username;
    }
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function isEnabled(): bool
    {
        return $this->enabled;
    }

    public function getGroups(): array
    {
        return $this->groups;
    }

    public function getAttributes(): array
    {
        return $this->attributes;
    }

    public function isEmailVerified(): bool
    {
        return $this->emailVerified;
    }

    public function toArray(): array
    {
        return [
            'firstName' => $this->firstName,
            'lastName' => $this->lastName,
            'email' => $this->email,
            'username' => $this->username,
            'enabled' => $this->enabled,
            'groups' => $this->groups,
            'attributes' => $this->attributes,
            'emailVerified' => $this->emailVerified
        ];
    }
}
