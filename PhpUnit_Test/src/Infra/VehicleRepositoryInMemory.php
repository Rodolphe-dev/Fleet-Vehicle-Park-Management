<?php

namespace PhpUnit_Test\Infra;

use PhpUnit_Test\Domain\Interface\VehicleRepositoryInterface;
use PhpUnit_Test\Domain\ValueObject\Vehicle;

class VehicleRepositoryInMemory implements VehicleRepositoryInterface
{
    protected $Vehicle;

    public function __construct()
    {
        $this->Vehicle = [];
    }

    public function getAll(): array
    {
        return $this->Vehicle;
    }

    public function exist(Vehicle $Vehicle)
    {
        return count($this->Vehicle);
    }

    public function getThisVehicle(Vehicle $Vehicle)
    {
        foreach ($this->Vehicle as $item) {
            if ($item->plateNumber == $Vehicle->plateNumber()) {
                return $item;
            }
        }
    }

    public function save(Vehicle $Vehicle): void
    {
        $this->Vehicle[] = $Vehicle;
    }

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