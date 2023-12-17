<?php

namespace PhpUnit_Test\Infra\CQRS;

use PhpUnit_Test\Domain\Interface\VehicleRepositoryInterface;
use PhpUnit_Test\Domain\ValueObject\Vehicle;

class ReadVehicleRepository
{
    protected $VehicleRepositoryInterface;

    public function __construct(VehicleRepositoryInterface $VehicleRepositoryInterface)
    {
        $this->VehicleRepositoryInterface = $VehicleRepositoryInterface;
    }

    public function getAll()
    {
        return $this->VehicleRepositoryInterface->getAll();
    }

    public function exist(Vehicle $Vehicle)
    {
        return $this->VehicleRepositoryInterface->exist($Vehicle);
    }

    public function getThisVehicle(Vehicle $Vehicle)
    {
        return $this->VehicleRepositoryInterface->getThisVehicle($Vehicle);
    }
}