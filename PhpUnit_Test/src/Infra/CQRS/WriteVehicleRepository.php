<?php

namespace PhpUnit_Test\Infra\CQRS;

use PhpUnit_Test\Domain\Interface\VehicleRepositoryInterface;
use PhpUnit_Test\Domain\ValueObject\Vehicle;

class WriteVehicleRepository
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
     * This will save a vehicle
     *
     * @param Vehicle $Vehicle  Object vehicle
     */
    public function save(Vehicle $Vehicle)
    {
        return $this->VehicleRepositoryInterface->save($Vehicle);
    }

    /**
     * This will park a vehicle
     *
     * @param Vehicle $Vehicle
     * @return object|null  Return the vehicle object with data or null if no result
     */
    public function park(Vehicle $Vehicle)
    {
        return $this->VehicleRepositoryInterface->park($Vehicle);
    }
}
