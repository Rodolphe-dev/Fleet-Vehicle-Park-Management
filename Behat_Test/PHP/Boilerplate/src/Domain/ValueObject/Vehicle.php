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

    /**
     * This is the fleet id of a vehicle
     *
     * @return string
     */
    public function fleetId(): string
    {
        return $this->fleetId;
    }

    /**
     * This is the plate number of a vehicle
     *
     * @return string
     */
    public function plateNumber(): string
    {
        return $this->plateNumber;
    }

    /**
     * This is the latitude location of a vehicle
     *
     * @return float
     */
    public function latitude(): float
    {
        return $this->latitude;
    }

    /**
     * This is the longitude location of a vehicle
     *
     * @return float
     */
    public function longitude(): float
    {
        return $this->longitude;
    }
}
