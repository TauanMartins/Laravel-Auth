<?php

namespace CerneTech\Keycloak\Model;

class KeycloakUserFilters
{
    private $filters = [];

    private function __construct(string $key, $value)
    {
        $this->filters[$key] = $value;
    }

    public static function USERNAME(string $username): self
    {
        return new self('username', $username);
    }

    public static function EMAIL(string $email): self
    {
        return new self('email', $email);
    }
    public static function UUID(string $uuid): self
    {
        return new self('id', $uuid);
    }

    public function toArray(): array
    {
        return $this->filters;
    }
}
