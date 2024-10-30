<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use CerneTech\Keycloak\Factory\KeycloakFactory;

class AuthController extends Controller
{
    private $keycloakFactory;
    public function __construct(KeycloakFactory $keycloakFactory)
    {
        $this->keycloakFactory = $keycloakFactory;
    }
    public function login(Request $request)
    {
        try {
            $username = $request->input('username');
            $password = $request->input('password');
            $tokens = $this->keycloakFactory->confidential()->login(['username' => $username, 'password' => $password])->toArray();
            return self::success($tokens);
        } catch (\Exception $e) {
            return self::error($e->getMessage(), $e->getCode());
        }
    }
}
