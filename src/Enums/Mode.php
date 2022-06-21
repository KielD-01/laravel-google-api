<?php
declare(strict_types=1);

namespace KielD01\LaravelGoogleApi\Enums;

final class Mode
{
    public const BICYCLING = 'bicycling';
    public const DRIVING = 'driving';
    public const WALKING = 'walking';

    public const AVAILABLE = [
        self::BICYCLING,
        self::DRIVING,
        self::WALKING
    ];

    public static function getAvailableModes(): array
    {
        return self::AVAILABLE;
    }
}