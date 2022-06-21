<?php
declare(strict_types=1);

namespace KielD01\LaravelGoogleApi\Enums;

final class Avoid
{
    public const FERRIES = 'ferries';
    public const HIGHWAYS = 'highways';
    public const INDOORS = 'indoors';
    public const TOLLS = 'tolls';

    public const AVAILABLE = [
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