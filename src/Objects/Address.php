<?php

namespace KielD01\LaravelGoogleApi\Objects;

class Address
{
    private string $address;

    public function __construct(string $address)
    {
        $this->address = $address;
    }

    public function getAddress(): string
    {
        return $this->address;
    }
}