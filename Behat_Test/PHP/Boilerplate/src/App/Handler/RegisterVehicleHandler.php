<?php

namespace Behat_Test\App\Handler;

use Behat_Test\Infra\CQRS\ReadFleetRepository;
use Behat_Test\Infra\CQRS\WriteFleetRepository;
use Behat_Test\Infra\CQRS\ReadVehicleRepository;
use Behat_Test\Infra\CQRS\WriteVehicleRepository;
use Behat_Test\Domain\ValueObject\Vehicle;
use Behat_Test\Domain\ValueObject\Fleet;

class RegisterVehicleHandler
{
    public function __construct(private ReadFleetRepository $ReadFleetRepository, private WriteFleetRepository $WriteFleetRepository , private ReadVehicleRepository $ReadVehicleRepository, private WriteVehicleRepository $WriteVehicleRepository)
    {
    }

    public function __invoke(Vehicle $RegisterVehicle)
    {
        $Vehicle = new Vehicle($RegisterVehicle->fleetId(), $RegisterVehicle->plateNumber(), $RegisterVehicle->latitude(), $RegisterVehicle->longitude());

        //Check if Fleet exist
        $Fleet = new Fleet($RegisterVehicle->fleetId());
        $checkFleet = $this->ReadFleetRepository->getFleetId($Fleet);

        if($checkFleet !== 0){
            //Check if Vehicle exist
            $checkVehicle = $this->ReadVehicleRepository->exist($Vehicle);

            if($checkVehicle === 0){
                $this->WriteVehicleRepository->save($Vehicle);
            }
        }

        return $Vehicle;
    }
}
