<?php
declare(strict_types=1);

namespace KielD01\LaravelGoogleApi;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Config;

abstract class Core
{
    private Client $client;
    private string $baseUriPattern = 'https://maps.googleapis.com/maps/api/{function}/';
    private string $baseUri;

    protected string $function;
    protected array $parameters = [];

    public function __construct()
    {
        $this->setBaseUri();

        $this->client = new Client([
            'base_uri' => $this->getBaseUri()
        ]);
    }

    protected function setBaseUri()
    {
        $this->baseUri = str_replace(
            ['{function}', '{key}'],
            [$this->function, Config::get('google.api.keys.distance_matrix')],
            $this->baseUriPattern
        );
    }

    protected function getClient(): Client
    {
        return $this->client;
    }

    protected function getBaseUri(): string
    {
        return $this->baseUri;
    }

    abstract protected function describeParameters(): void;

    abstract protected function validation(): bool;
}