<?php

namespace PhpUnit_Test\Domain\Interface;

use PhpUnit_Test\Domain\ValueObject\Vehicle;

interface VehicleRepositoryInterface
{
    public function getAll(): array;

    public function getThisVehicle(Vehicle $Vehicle);

    public function exist(Vehicle $Vehicle);

    public function save(Vehicle $Vehicle): void;

    public function park(Vehicle $Vehicle);
}
