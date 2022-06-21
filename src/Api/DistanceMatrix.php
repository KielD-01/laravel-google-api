<?php
declare(strict_types=1);

namespace KielD01\LaravelGoogleApi\Api;

use JetBrains\PhpStorm\Pure;
use KielD01\LaravelGoogleApi\Core;
use KielD01\LaravelGoogleApi\Result;
use KielD01\LaravelGoogleApi\Results\DistanceMatrixResult;

class DistanceMatrix extends Core
{
    protected string $function = 'distancematrix';
    protected string $apiKeyType = 'distance_matrix';
    protected array $destinations = [];
    protected array $origins = [];

    protected string $resultClass = DistanceMatrixResult::class;

    protected function describeParameters(): void
    {
        $this->parameters = [
            'required' => [
                'destinations',
                'origins',
            ],
            'optional' => [
                // ToDo : TBD
            ]
        ];
    }

    #[Pure] protected function validation(): bool
    {
        return count($this->getOrigins()) === count($this->getDestinations());
    }

    public function getOrigins(): array
    {
        return $this->origins;
    }

    public function getDestinations(): array
    {
        return $this->destinations;
    }

    public function addRoute(string $origin, string $destination): static
    {
        $this->origins[] = $origin;
        $this->destinations[] = $destination;

        return $this;
    }

    public function bindParameters(): void
    {
        $this->setParameter('origins', implode('|', $this->getOrigins()));
        $this->setParameter('destinations', implode('|', $this->getDestinations()));
    }

    protected function processResponse(array $result): Result
    {
        return resolve(DistanceMatrixResult::class, compact('result'));
    }

    protected function reset(): void
    {
        $this->origins = [];
        $this->destinations = [];
        $this->parameters = [
            'required' => [],
            'optional' => []
        ];
    }
}