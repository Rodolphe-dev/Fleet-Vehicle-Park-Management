<?php

namespace Behat_Test\Infra\CQRS;

use Behat_Test\Domain\Interface\FleetRepositoryInterface;
use Behat_Test\Domain\ValueObject\Fleet;

class WriteFleetRepository
{
    /**
     * This will allow to use the fleet repository interface
     *
     * @var interface $FleetRepositoryInterface  the fleet repository interface
     */
    protected $FleetRepositoryInterface;

    public function __construct(FleetRepositoryInterface $FleetRepositoryInterface)
    {
        $this->FleetRepositoryInterface = $FleetRepositoryInterface;
    }

    /**
     * This will save a fleet
     *
     * @param Fleet $Fleet  Object fleet
     */
    public function save(Fleet $Fleet)
    {
        return $this->FleetRepositoryInterface->save($Fleet);
    }
}
