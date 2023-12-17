<?php

namespace PhpUnit_Test\Infra\CQRS;

use PhpUnit_Test\Domain\Interface\FleetRepositoryInterface;
use PhpUnit_Test\Domain\ValueObject\Fleet;

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