<?php
declare(strict_types=1);

namespace KielD01\LaravelGoogleApi;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Str;
use Psr\Http\Message\ResponseInterface;

abstract class Core
{
    private Client $client;
    private string $baseUriPattern = 'https://maps.googleapis.com/maps/api/{function}/';
    private string $baseUri;
    private string $key;

    protected string $apiKeyType;
    protected string $function;
    protected array $parameters = [];

    protected string $resultClass;

    public function __construct()
    {
        $this->setBaseUri();
        $this->setKey();

        $this->client = new Client([
            'base_uri' => $this->getBaseUri(),
            'verify' => $this->getVerify()
        ]);
    }

    private function getVerify(): bool
    {
        return Str::is('production', config('app.env'));
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

    abstract protected function validation(): bool;

    abstract protected function bindParameters(): void;

    abstract protected function describeParameters(): void;

    abstract protected function processResponse(array $result): Result;

    /**
     * @throws GuzzleException
     */
    private function getJsonResponse()
    {
        $response = $this->client->get(
            'json',
            [
                'query' => array_merge($this->getParameters(), ['key' => $this->getKey()])
            ]
        );

        return $this->processJsonResponse($response);
    }

    private function processJsonResponse(ResponseInterface $response)
    {
        return json_decode($response->getBody()->getContents(), true, 512, 128);
    }

    /**
     * ToDo : Process $result into decent object
     *
     * @return mixed
     * @uses \KielD01\LaravelGoogleApi\Core::getJsonResponse()
     *
     * @uses \KielD01\LaravelGoogleApi\Core::getXmlResponse()
     */
    public function result(): mixed
    {
        $responseTypes = [
            'xml' => 'getXmlResponse',
            'json' => 'getJsonResponse'
        ];

        $this->bindParameters();

        return resolve(
            $this->resultClass,
            ['result' => $this->{$responseTypes[config('google.response', 'json')]}()]
        );
    }
}
