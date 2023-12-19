<?php

namespace Behat_Test\Domain\ValueObject;

class Vehicle
{
    public function __construct(
        public string $fleetId,
        public string $plateNumber,
        public float $latitude,
        public float $longitude
    ) {
        $this->fleetId = $fleetId;
        $this->plateNumber = $plateNumber;
        $this->latitude = $latitude;
        $this->longitude = $longitude;
    }

    public function fleetId(): string
    {
        return $this->fleetId;
    }

    public function plateNumber(): string
    {
        return $this->plateNumber;
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
