<?php

namespace Behat_Test\Domain\ValueObject;

final class Location
{
    public function __construct(
        public float $latitude,
        public float $longitude
    ) {
        $this->latitude = $latitude;
        $this->longitude = $longitude;
    }

    /**
     * This is the latitude of a location
     *
     * @return float
     */
    public function latitude(): float
    {
        return $this->latitude;
    }

    /**
     * This is the longitude of a location
     *
     * @return float
     */
    public function longitude(): float
    {
        return $this->longitude;
    }
}
