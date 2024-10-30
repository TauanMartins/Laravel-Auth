<?php

namespace CerneTech\Keycloak\Util;

class KeycloakHTTPHeader
{
    private array $headers = [];
    private string $payloadWraper = 'form_params';

    public function __construct()
    {
        $this->setContentTypeApplicationFormUrlEncoded();
    }

    public function setContentTypeApplicationFormUrlEncoded(): self
    {
        $this->headers['content-type'] = 'application/x-www-form-urlencoded';
        $this->payloadWraper = 'form_params';
        return $this;
    }

    public function setContentTypeApplicationJson(): self
    {
        $this->headers['content-type'] = 'application/json';
        $this->payloadWraper = 'json';
        return $this;
    }

    public function payloadWraper(): string
    {
        return $this->payloadWraper;
    }

    public function setAuthorizationBearer(string $value): self
    {
        $this->headers['Authorization'] = sprintf('Bearer %s', $value);
        return $this;
    }

    public function parse(): array
    {
        return $this->headers;
    }
}
