<?php

namespace Behat_Test\Domain\Interface;

use Behat_Test\Domain\ValueObject\Vehicle;

interface VehicleRepositoryInterface
{
    /**
     * This will get the list of all the vehicle registered
     *
     * @return array|null  Return the result array or null if no results
     */
    public function getAll(): array;

    /**
     * This will get the vehicle data
     *
     * @param Vehicle $Vehicle  Object vehicle
     * @return object|null  Return the vehicle object with data or null if no result
     */
    public function getThisVehicle(Vehicle $Vehicle): object;

    /**
     * This will check if a vehicle exist
     *
     * @param Vehicle $Vehicle  Object Vehicle
     * @return integer  Return number of vehicle who got the same plateNumber
     */
    public function exist(Vehicle $Vehicle): int;

    /**
     * This will save a vehicle
     *
     * @param Vehicle $Vehicle  Object vehicle
     */
    public function save(Vehicle $Vehicle): void;

    /**
     * This will park a vehicle
     *
     * @param Vehicle $Vehicle
     * @return object|null  Return the vehicle object with data or null if no result
     */
    public function park(Vehicle $Vehicle);
}
