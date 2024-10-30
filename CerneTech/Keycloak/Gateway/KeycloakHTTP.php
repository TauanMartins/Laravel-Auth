<?php

namespace CerneTech\Keycloak\Gateway;

use GuzzleHttp\Client;
use CerneTech\Keycloak\Util\KeycloakHTTPHeader;

class KeycloakHTTP
{
    private Client $client;
    private static $instance;
    private static $SSLVerify = false;

    public static function selfer(): self
    {
        if (!self::$instance) {
            self::$instance = new self();
            self::$instance->client = new Client(['verify' => self::$SSLVerify]);
        }

        return self::$instance;
    }

    /**
     * Método genérico para fazer qualquer tipo de solicitação HTTP.
     *
     * @param string $method O método HTTP (GET, POST, PUT, DELETE, etc.)
     * @param string $url A URL para a qual a solicitação será enviada
     * @param array $payload O corpo da solicitação
     * @param KeycloakHTTPHeader|null $headers Os cabeçalhos da solicitação
     * @return mixed A resposta da solicitação
     */
    public static function request(string $method, string $url, array $payload = [], ?KeycloakHTTPHeader $headers = null)
    {
        $headers = $headers ?? new KeycloakHTTPHeader();

        return self::selfer()->client->request(
            $method,
            $url,
            [
                'headers' => $headers->parse(),
                $headers->payloadWraper() => $payload,
                'http_errors' => true
            ]
        );
    }
    public static function post(string $url, array $payload, ?KeycloakHTTPHeader $headers = null)
    {
        return self::request('POST', $url, $payload, $headers);
    }

    public static function get(string $url, ?KeycloakHTTPHeader $headers = null)
    {
        return self::request('GET', $url, [], $headers);
    }

    public static function delete(string $url, ?KeycloakHTTPHeader $headers = null)
    {
        return self::request('DELETE', $url, [], $headers);
    }

    public static function put(string $url, array $payload, ?KeycloakHTTPHeader $headers = null)
    {
        return self::request('PUT', $url, $payload, $headers);
    }
}
