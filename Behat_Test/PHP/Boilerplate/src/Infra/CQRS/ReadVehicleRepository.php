<?php

namespace Behat_Test\Infra\CQRS;

use Behat_Test\Domain\Interface\VehicleRepositoryInterface;
use Behat_Test\Domain\ValueObject\Vehicle;

class ReadVehicleRepository
{
    /**
     * This will allow to use the vehicle repository interface
     *
     * @var interface $VehicleRepositoryInterface  the vehicle repository interface
     */
    protected $VehicleRepositoryInterface;

    public function __construct(VehicleRepositoryInterface $VehicleRepositoryInterface)
    {
        $this->VehicleRepositoryInterface = $VehicleRepositoryInterface;
    }

    /**
     * This will get the list of all the vehicle registered
     *
     * @return array|null  Return the result array or null if no results
     */
    public function getAll(): array
    {
        return $this->VehicleRepositoryInterface->getAll();
    }

    /**
     * This will get the vehicle data
     *
     * @param Vehicle $Vehicle  Object vehicle
     * @return object|null  Return the vehicle object with data or null if no result
     */
    public function getThisVehicle(Vehicle $Vehicle): object
    {
        return $this->VehicleRepositoryInterface->getThisVehicle($Vehicle);
    }

    /**
     * This will check if a vehicle exist
     *
     * @param Vehicle $Vehicle  Object Vehicle
     * @return integer  Return number of vehicle who got the same plateNumber
     */
    public function exist(Vehicle $Vehicle): int
    {
        return $this->VehicleRepositoryInterface->exist($Vehicle);
    }
}
