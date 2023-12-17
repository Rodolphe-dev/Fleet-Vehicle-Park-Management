<?php

namespace PhpUnit_Test\App\Handler;

use PhpUnit_Test\Infra\CQRS\ReadFleetRepository;
use PhpUnit_Test\Infra\CQRS\WriteFleetRepository;
use PhpUnit_Test\Infra\CQRS\ReadVehicleRepository;
use PhpUnit_Test\Infra\CQRS\WriteVehicleRepository;
use PhpUnit_Test\Domain\ValueObject\Vehicle;
use PhpUnit_Test\Domain\ValueObject\Location;

class LocalizeVehicleHandler
{
    public function __construct(private ReadFleetRepository $ReadFleetRepository, private WriteFleetRepository $WriteFleetRepository , private ReadVehicleRepository $ReadVehicleRepository, private WriteVehicleRepository $WriteVehicleRepository)
    {
    }

    public function __invoke(Vehicle $LocalizeVehicle, Location $Location)
    {
        //Get my vehicle
        $getVehicle = $this->ReadVehicleRepository->getThisVehicle($LocalizeVehicle);

        return $getVehicle;
    }
}
