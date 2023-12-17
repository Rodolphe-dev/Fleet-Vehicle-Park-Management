<?php

namespace PhpUnit_Test\Domain\ValueObject;

final class Location
{
    public function __construct(
        public float $latitude,
        public float $longitude
        )
    {
        $this->latitude = $latitude;
        $this->longitude = $longitude;
    }

    public function latitude(): float
    {
        return $this->latitude;
    }

    public function longitude(): float
    {
        return $this->longitude;
    }
}
