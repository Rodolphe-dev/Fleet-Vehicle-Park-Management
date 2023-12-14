<?php

namespace Behat_Test\Domain\Interface;

use Behat_Test\Domain\ValueObject\Vehicle;

interface VehicleRepositoryInterface
{
    public function getAll(): array;

    public function getThisVehicle(Vehicle $Vehicle);

    public function exist(Vehicle $Vehicle);

    public function save(Vehicle $Vehicle): void;

    public function park(Vehicle $Vehicle);
}
