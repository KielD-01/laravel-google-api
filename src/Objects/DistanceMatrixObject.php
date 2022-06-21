<?php

namespace KielD01\LaravelGoogleApi\Objects;

class DistanceMatrixObject
{
    private Distance $distance;
    private Duration $duration;
    private string $status;

    public function __construct(array $distance, array $duration, string $status)
    {
        $this->distance = new Distance($distance['text'], $distance['value']);
        $this->duration = new Duration($duration['text'], $duration['value']);
        $this->status = $status;
    }

    public function getDistance(): Distance
    {
        return $this->distance;
    }

    public function getDuration(): Duration
    {
        return $this->duration;
    }

    public function getStatus(): string
    {
        return $this->status;
    }
}