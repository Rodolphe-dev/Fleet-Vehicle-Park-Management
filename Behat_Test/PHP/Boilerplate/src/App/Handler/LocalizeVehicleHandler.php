<?php

namespace Behat_Test\App\Handler;

use Behat_Test\Infra\CQRS\ReadFleetRepository;
use Behat_Test\Infra\CQRS\WriteFleetRepository;
use Behat_Test\Infra\CQRS\ReadVehicleRepository;
use Behat_Test\Infra\CQRS\WriteVehicleRepository;
use Behat_Test\Domain\ValueObject\Vehicle;
use Behat_Test\Domain\ValueObject\Location;

class LocalizeVehicleHandler
{
    public function __construct(
        private ReadFleetRepository $ReadFleetRepository,
        private WriteFleetRepository $WriteFleetRepository,
        private ReadVehicleRepository $ReadVehicleRepository,
        private WriteVehicleRepository $WriteVehicleRepository
    ) {
    }

    public function __invoke(Vehicle $LocalizeVehicle, Location $Location)
    {
        //Get my vehicle
        $getVehicle = $this->ReadVehicleRepository->getThisVehicle($LocalizeVehicle);

        return $getVehicle;
    }
}
