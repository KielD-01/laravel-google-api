<?php

return [
    'api' => [
        'keys' => [
            'distance_matrix' => env('GOOGLE_DISTANCE_MATRIX_KEY')
        ]
    ],
    'standalone' => [],
    'caching' => [

        /**
         * Caching can be in two variants:
         * 1. Boolean (true, false)
         * 2. Array ([\KielD01\LaravelGoogleApi\Api\DistanceMatrix::class, ...])
         * @see \KielD01\LaravelGoogleApi\Api\\KielD01\LaravelGoogleApi\Api\DistanceMatrix
         *
         * If array, then class must extend \KielD01\LaravelGoogleApi\Core::class
         * @see \KielD01\LaravelGoogleApi\Core
         */
        'enabled' => env('GOOGLE_CACHING_ENABLED', false),

        /**
         * TTL - in seconds
         * 60   - 1 Minute
         * 300  - 5 Minutes
         * 600  - 10 Minutes
         * 900  - 15 Minutes
         * 1800 - 30 Minutes
         * 3600 - 1 Hour (default)
         *
         * 0    - forever
         */
        'ttl' => env('GOOGLE_CACHE_TTL', 3600),
    ]
];