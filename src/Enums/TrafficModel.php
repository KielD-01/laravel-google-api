<?php
declare(strict_types=1);

namespace KielD01\LaravelGoogleApi\Enums;

final class TrafficModel
{
    public const BEST_GUESS = 'best_guess';
    public const OPTIMISTIC = 'optimistic';
    public const PESSIMISTIC = 'pessimistic';

    public const AVAILABLE = [
        self::BEST_GUESS,
        self::OPTIMISTIC,
        self::PESSIMISTIC
    ];

    public static function getAvailableTrafficModels(): array
    {
        return self::AVAILABLE;
    }
}