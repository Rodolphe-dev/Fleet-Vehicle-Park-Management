<?php

namespace Behat_Test\Infra\CQRS;

use Behat_Test\Domain\Interface\FleetRepositoryInterface;
use Behat_Test\Domain\ValueObject\Fleet;

class ReadFleetRepository
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
     * This will get the list of all the fleet registered
     *
     * @return array|null  Return the result array or null if no results
     */
    public function getAll(): array
    {
        return $this->FleetRepositoryInterface->getAll();
    }

    /**
     * This will get the fleet id
     *
     * @param Fleet $Fleet  Object fleet
     * @return string|null  Return the fleet id or null if no result
     */
    public function getFleetId(Fleet $Fleet): object
    {
        return $this->FleetRepositoryInterface->getFleetId($Fleet);
    }

    /**
     * This will check if a fleet exist
     *
     * @param Fleet $Fleet  Object fleet
     * @return integer  Return number of fleet who got the same fleet id
     */
    public function exist(Fleet $Fleet): int
    {
        return $this->FleetRepositoryInterface->exist($Fleet);
    }
}
