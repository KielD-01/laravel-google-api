<?php
declare(strict_types=1);

namespace KielD01\LaravelGoogleApi\Objects;

/**
 * @property string $textDistance
 * @property int $distance
 */
class Distance
{
    private string $textDistance;
    private int $distance;

    public function __construct(string $textDistance, int $distance)
    {
        $this->textDistance = $textDistance;
        $this->distance = $distance;
    }

    public function getTextDistance(): string
    {
        return $this->textDistance;
    }

    public function getDistance(): int
    {
        return $this->distance;
    }
}