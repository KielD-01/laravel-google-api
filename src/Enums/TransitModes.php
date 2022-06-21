<?php
declare(strict_types=1);

namespace KielD01\LaravelGoogleApi\Enums;

final class TransitModes
{
    public const BUS = 'bus';
    public const RAIL = 'rail';
    public const SUBWAY = 'subway';
    public const TRAIN = 'train';
    public const TRAM = 'tram';

    public const AVAILABLE = [
        self::BUS,
        self::RAIL,
        self::TRAIN,
        self::TRAM,
        self::SUBWAY
    ];

    public static function getAvailableTransitModes(): array
    {
        return self::AVAILABLE;
    }

}