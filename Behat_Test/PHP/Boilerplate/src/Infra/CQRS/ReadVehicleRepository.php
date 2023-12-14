<?php

namespace Behat_Test\Infra\CQRS;

use Behat_Test\Domain\Interface\VehicleRepositoryInterface;
use Behat_Test\Domain\ValueObject\Vehicle;

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