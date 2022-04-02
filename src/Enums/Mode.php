<?php
declare(strict_types=1);

namespace KielD01\LaravelGoogleApi\Enums;

final class Mode
{
    const BICYCLING = 'bicycling';
    const DRIVING = 'driving';
    const WALKING = 'walking';

    const AVAILABLE = [
        self::BICYCLING,
        self::DRIVING,
        self::WALKING
    ];

    public static function getAvailableModes(): array
    {
        return self::AVAILABLE;
    }
}