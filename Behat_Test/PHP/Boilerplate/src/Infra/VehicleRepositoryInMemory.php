<?php

namespace Behat_Test\Infra;

use Behat_Test\Domain\Interface\VehicleRepositoryInterface;
use Behat_Test\Domain\ValueObject\Vehicle;

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

    public function getThisVehicle(Vehicle $Vehicle)
    {
        if (isset($this->Vehicle[$Vehicle->plateNumber()])) {
            return $this->Vehicle[$Vehicle->plateNumber()];
        }else{
            return null;
        }
    }

    public function save(Vehicle $Vehicle): void
    {
        $this->Vehicle[] = $Vehicle;
    }

    public function park(Vehicle $Vehicle)
    {
        $this->Vehicle[$Vehicle->PlateNumber()]->latitude = $Vehicle->latitude();
        $this->Vehicle[$Vehicle->PlateNumber()]->longitude = $Vehicle->longitude();

        return $this->Vehicle[$Vehicle->PlateNumber()];
    }
}