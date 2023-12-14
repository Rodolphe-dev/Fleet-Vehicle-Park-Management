<?php

namespace Behat_Test\Infra\CQRS;

use Behat_Test\Domain\Interface\FleetRepositoryInterface;
use Behat_Test\Domain\ValueObject\Fleet;

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