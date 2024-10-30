<?php

namespace CerneTech\Keycloak\Middleware;

use Closure;
use Exception;
use Illuminate\Http\Request;
use CerneTech\Keycloak\Factory\KeycloakFactory;


class ValidateKeycloakToken
{
    private $keycloakFactory;
    public function __construct(KeycloakFactory $keycloakFactory)
    {
        $this->keycloakFactory = $keycloakFactory;
    }
    public function handle(Request $request, Closure $next)
    {
        try {
            $token = $request->bearerToken();
            $valid = $this->keycloakFactory->confidential()->validateToken($token);
            if (!$valid->active) {
                return response()->json(['message' => 'invalid.token'], 401);
            }
            $request->merge(['uuuid' => $valid->sub, 'username' => $valid->username, 'token' => (array) $valid]);
            return $next($request);
        } catch (Exception $e) {
            return response()->json(['message' => 'invalid.token'], 401);
        }
    }
}
