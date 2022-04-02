<?php
declare(strict_types=1);

namespace KielD01\LaravelGoogleApi\Enums;

final class TransitModes
{
    const BUS = 'bus';
    const RAIL = 'rail';
    const SUBWAY = 'subway';
    const TRAIN = 'train';
    const TRAM = 'tram';

    const AVAILABLE = [
        self::BUS,
        self::RAIL,
        self::TRAIN,
        self::TRAM,
    ];

    public static function getAvailableTransitModes(): array
    {
        return self::AVAILABLE;
    }

}