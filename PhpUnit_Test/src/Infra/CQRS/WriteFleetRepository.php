<?php

namespace PhpUnit_Test\Infra\CQRS;

use PhpUnit_Test\Domain\Interface\FleetRepositoryInterface;
use PhpUnit_Test\Domain\ValueObject\Fleet;

class WriteFleetRepository
{
    protected $FleetRepositoryInterface;

    public function __construct(FleetRepositoryInterface $FleetRepositoryInterface)
    {
        $this->FleetRepositoryInterface = $FleetRepositoryInterface;
    }
    
    public function save(Fleet $Fleet)
    {
        return $this->FleetRepositoryInterface->save($Fleet);
    }
}