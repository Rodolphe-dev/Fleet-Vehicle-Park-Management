<?php

namespace Behat_Test\Infra\CQRS;

use Behat_Test\Domain\Interface\FleetRepositoryInterface;
use Behat_Test\Domain\ValueObject\Fleet;

class ReadFleetRepository
{
    protected $FleetRepositoryInterface;

    public function __construct(FleetRepositoryInterface $FleetRepositoryInterface)
    {
        $this->FleetRepositoryInterface = $FleetRepositoryInterface;
    }

    public function getAll()
    {
        return $this->FleetRepositoryInterface->getAll();
    }

    public function exist(Fleet $Fleet)
    {
        return $this->FleetRepositoryInterface->exist($Fleet);
    }

    public function getFleetId(Fleet $Fleet)
    {
        return $this->FleetRepositoryInterface->getFleetId($Fleet);
    }
}