<?php

namespace Behat_Test\App\Handler;

use Behat_Test\Infra\CQRS\ReadFleetRepository;
use Behat_Test\Infra\CQRS\WriteFleetRepository;
use Behat_Test\Domain\ValueObject\Fleet;

class CreateFleetHandler
{
    public function __construct(
        private ReadFleetRepository $ReadFleetRepository,
        private WriteFleetRepository $WriteFleetRepository
    ) {
    }

    public function __invoke(Fleet $CreateFleet)
    {
        $Fleet = new Fleet($CreateFleet->fleetId());

        //Check if fleet exist
        $checkFleet = $this->ReadFleetRepository->exist($Fleet);

        if ($checkFleet === 0) {
            $this->WriteFleetRepository->save($Fleet);
        }
        return $Fleet;
    }
}
