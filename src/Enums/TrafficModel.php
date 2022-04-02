<?php
declare(strict_types=1);

namespace KielD01\LaravelGoogleApi\Enums;

final class TrafficModel
{
    const BEST_GUESS = 'best_guess';
    const OPTIMISTIC = 'optimistic';
    const PESSIMISTIC = 'pessimistic';

    const AVAILABLE = [
        self::BEST_GUESS,
        self::OPTIMISTIC,
        self::PESSIMISTIC
    ];

    public static function getAvailableTrafficModels(): array
    {
        return self::AVAILABLE;
    }
}