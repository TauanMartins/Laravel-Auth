<?php

namespace CerneTech\_Infra\Provider;

use Illuminate\Support\ServiceProvider;

use CerneTech\Keycloak\Interface\KeycloakInterface;
use CerneTech\Keycloak\Service\KeycloakService;
class CerneTechServiceProvider extends ServiceProvider
{
    public function register()
    {
        // Keycloak
        $this->app->bind(KeycloakInterface::class, KeycloakService::class);
    }
}