<?php
declare(strict_types=1);

namespace KielD01\LaravelGoogleApi\Enums;

final class Avoid
{
    const FERRIES = 'ferries';
    const HIGHWAYS = 'highways';
    const INDOORS = 'indoors';
    const TOLLS = 'tolls';

    const AVAILABLE = [
        self::FERRIES,
        self::HIGHWAYS,
        self::INDOORS,
        self::TOLLS,
    ];

    public static function getAvailableAvoids(): array
    {
        return self::AVAILABLE;
    }
}