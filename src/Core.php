<?php
declare(strict_types=1);

namespace KielD01\LaravelGoogleApi;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Psr\Http\Message\ResponseInterface;

abstract class Core
{
    private Client $client;
    private string $baseUriPattern = 'https://maps.googleapis.com/maps/api/{function}/';
    private string $baseUri;
    private string $key;
    private bool $caching = false;

    protected string $apiKeyType;
    protected string $function;
    protected array $parameters = [];

    protected string $resultClass;

    public function __construct()
    {
        $this->setBaseUri();
        $this->setKey();

        $this->checkIfCachingEnabled();

        $this->client = new Client([
            'base_uri' => $this->getBaseUri(),
            'verify' => $this->getVerify()
        ]);
    }

    private function getVerify(): bool
    {
        return Str::is('production', config('app.env'));
    }

    protected function setBaseUri(): void
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

    protected function setParameter($parameter, $value): void
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

    private function sanitizeParameters(): void
    {
        $allowedParameters = array_merge(
            array_keys($this->parameters['required'] ?? []),
            array_keys($this->parameters['optional'] ?? []),
        );

        $forbiddenParameters = array_diff(
            array_keys($this->getParameters()),
            $allowedParameters
        );

        array_map(function (string|int $fp) {
            unset($this->parameters[$fp]);
        }, $forbiddenParameters);
    }

    /**
     * @throws GuzzleException
     * @throws Exception
     */
    private function getJsonResponse()
    {
        $query = array_merge($this->getParameters(), ['key' => $this->getKey()]);
        $assumedCacheKey = sprintf('%s_%s', $this->function, md5(http_build_query($query)));
        $cachingPeriod = config('google.caching.ttl');
        $isForeverCaching = $cachingPeriod === 0;

        if ($this->isCachingEnabled() && ($response = Cache::get($assumedCacheKey, false)) === false) {
            $response = $this->getClient()->get('json', compact('query'));

            $cachingArgs = [$assumedCacheKey, $response];

            if ($isForeverCaching) {
                $cachingPeriod[] = $cachingPeriod;
            }

            forward_static_call([Cache::class, $isForeverCaching ? 'forever' : 'put'], ...$cachingArgs);
        }

        if (!isset($response)) {
            throw new Exception(sprintf("No Response found for %s", $this->function));
        }

        return $this->processJsonResponse($response);
    }

    private function processJsonResponse(ResponseInterface $response)
    {
        return json_decode($response->getBody()->getContents(), true, 512, 128);
    }

    /**
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
        $this->sanitizeParameters();

        return resolve(
            $this->resultClass,
            ['result' => $this->{$responseTypes[config('google.response', 'json')]}()]
        );
    }

    private function checkIfCachingEnabled(): void
    {
        /** @var bool|array $cachingRule */
        $cachingRule = config('google.caching.enabled');

        if (is_bool($cachingRule)) {
            $this->setIsCachingEnabled($cachingRule);
        }

        if (is_array($cachingRule)) {
            $this->setIsCachingEnabled(in_array(__CLASS__, $cachingRule));
        }

    }

    protected function isCachingEnabled(): bool
    {
        return $this->caching;
    }

    protected function setIsCachingEnabled(bool $isCachingEnabled): void
    {
        $this->caching = $isCachingEnabled;
    }
}
