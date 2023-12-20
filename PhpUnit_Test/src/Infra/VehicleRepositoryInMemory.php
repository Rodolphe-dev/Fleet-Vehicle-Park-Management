<?php

namespace PhpUnit_Test\Infra;

use PhpUnit_Test\Domain\Interface\VehicleRepositoryInterface;
use PhpUnit_Test\Domain\ValueObject\Vehicle;

class VehicleRepositoryInMemory implements VehicleRepositoryInterface
{
    /**
     * Array who list all the vehicle
     *
     * @var array $Vehicle  Vehicle array
     */
    protected $Vehicle;

    public function __construct()
    {
        $this->Vehicle = [];
    }

    /**
     * This will get the list of all the vehicle registered
     *
     * @return array|null  Return the result array or null if no results
     */
    public function getAll(): array
    {
        return $this->Vehicle;
    }

    /**
     * This will get the vehicle data
     *
     * @param Vehicle $Vehicle  Object vehicle
     * @return object|null  Return the vehicle object with data or null if no result
     */
    public function getThisVehicle(Vehicle $Vehicle): object
    {
        foreach ($this->Vehicle as $item) {
            if ($item->plateNumber == $Vehicle->plateNumber()) {
                return $item;
            }
        }
    }

    /**
     * This will check if a vehicle exist
     *
     * @param Vehicle $Vehicle  Object Vehicle
     * @return integer  Return number of vehicle who got the same plateNumber
     */
    public function exist(Vehicle $Vehicle): int
    {
        $i = 0;
        foreach ($this->Vehicle as $item) {
            if ($item->plateNumber == $Vehicle->plateNumber()) {
                $i++;
            }
        }
        return $i;
    }

    /**
     * This will save a vehicle
     *
     * @param Vehicle $Vehicle  Object vehicle
     */
    public function save(Vehicle $Vehicle): void
    {
        $this->Vehicle[] = $Vehicle;
    }

    /**
     * This will park a vehicle
     *
     * @param Vehicle $Vehicle
     * @return object|null  Return the vehicle object with data or null if no result
     */
    public function park(Vehicle $Vehicle)
    {
        foreach ($this->Vehicle as $item) {
            if ($item->plateNumber == $Vehicle->plateNumber()) {
                $item->latitude = $Vehicle->latitude();
                $item->longitude = $Vehicle->longitude();

                return $item;
            }
        }
    }
}
