<?php
declare(strict_types=1);

namespace KielD01\LaravelGoogleApi\Api;

use JetBrains\PhpStorm\Pure;
use KielD01\LaravelGoogleApi\Core;

class DistanceMatrix extends Core
{
    protected string $function = 'distancematrix';

    protected array $destinations = [];
    protected array $origins = [];

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
}