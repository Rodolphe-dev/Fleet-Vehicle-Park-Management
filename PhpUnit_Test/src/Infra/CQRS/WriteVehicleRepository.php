<?php

namespace PhpUnit_Test\Infra\CQRS;

use PhpUnit_Test\Domain\Interface\VehicleRepositoryInterface;
use PhpUnit_Test\Domain\ValueObject\Vehicle;

class WriteVehicleRepository
{
    protected $VehicleRepositoryInterface;

    public function __construct(VehicleRepositoryInterface $VehicleRepositoryInterface)
    {
        $this->VehicleRepositoryInterface = $VehicleRepositoryInterface;
    }
    
    public function save(Vehicle $Vehicle)
    {
        return $this->VehicleRepositoryInterface->save($Vehicle);
    }
    
    public function park(Vehicle $Vehicle)
    {
        return $this->VehicleRepositoryInterface->park($Vehicle);
    }
}