<?php
declare(strict_types=1);

namespace KielD01\LaravelGoogleApi;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

abstract class Core
{
    private Client $client;
    private string $baseUriPattern = 'https://maps.googleapis.com/maps/api/{function}/json/';
    private string $baseUri;
    private string $key;

    protected string $apiKeyType;
    protected string $function;
    protected array $parameters = [];

    public function __construct()
    {
        $this->setBaseUri();
        $this->setKey();

        $this->client = new Client([
            'base_uri' => $this->getBaseUri()
        ]);
    }

    protected function setBaseUri()
    {
        $this->baseUri = str_replace('{function}', $this->function, $this->baseUriPattern);
    }

    protected function getClient(): Client
    {
        return $this->client;
    }

    protected function getBaseUri(): string
    {
        return $this->baseUri;
    }

    private function setKey(): void
    {
        $this->key = config(sprintf('google.api.keys.%s', $this->getApiKeyType()));
    }

    private function getKey(): string
    {
        return $this->key;
    }

    private function getApiKeyType(): string
    {
        return $this->apiKeyType;
    }

    protected function setParameter($parameter, $value)
    {
        $this->parameters[$parameter] = $value;
    }

    protected function getParameters(): array
    {
        return $this->parameters;
    }

    abstract protected function describeParameters(): void;

    abstract protected function validation(): bool;

    abstract protected function bindParameters(): void;

    /**
     * @throws GuzzleException
     */
    public function getJsonResponse()
    {
        $response = $this->client->get('/json', $this->getParameters() + ['key' => $this->getKey()]);
    }
}