<?php

namespace PhpUnit_Test\App\Handler;

use PhpUnit_Test\Infra\CQRS\ReadFleetRepository;
use PhpUnit_Test\Infra\CQRS\WriteFleetRepository;
use PhpUnit_Test\Infra\CQRS\ReadVehicleRepository;
use PhpUnit_Test\Infra\CQRS\WriteVehicleRepository;
use PhpUnit_Test\Domain\ValueObject\Vehicle;

class ParkVehicleHandler
{
    public function __construct(
        private ReadFleetRepository $ReadFleetRepository,
        private WriteFleetRepository $WriteFleetRepository,
        private ReadVehicleRepository $ReadVehicleRepository,
        private WriteVehicleRepository $WriteVehicleRepository
    ) {}

    /**
     * This will handle to park a vehicle to a location
     *
     * @param Vehicle $Vehicle  Object vehicle
     * @return object|null  Return the vehicle object with data or null if no result
     */
    public function __invoke(Vehicle $Vehicle)
    {
        //Get my vehicle
        $getVehicle = $this->ReadVehicleRepository->getThisVehicle($Vehicle);

        $parkVehicle = new Vehicle(
            $Vehicle->FleetId(),
            $Vehicle->PlateNumber(),
            $Vehicle->latitude(),
            $Vehicle->longitude()
        );

        //Check If Vehicle is already parked at my location
        if (
            $parkVehicle->latitude() !== $getVehicle->latitude
            and
            $parkVehicle->longitude() !== $getVehicle->latitude
        ) {
            $this->WriteVehicleRepository->Park($parkVehicle);
        }
        return $parkVehicle;
    }
}
