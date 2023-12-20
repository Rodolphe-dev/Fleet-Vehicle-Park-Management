<?php

namespace Behat_Test\Infra;

use Behat_Test\Domain\Interface\FleetRepositoryInterface;
use Behat_Test\Domain\ValueObject\Fleet;

class FleetRepositoryInMemory implements FleetRepositoryInterface
{
    /**
     * Array who list all the fleet
     *
     * @var array $Fleet  Fleet array
     */
    protected $Fleet;

    public function __construct()
    {
        $this->Fleet = [];
    }

    /**
     * This will get the list of all the fleet registered
     *
     * @return array|null  Return the result array or null if no results
     */
    public function getAll(): array
    {
        return $this->Fleet;
    }

    /**
     * This will get the fleet id
     *
     * @param Fleet $Fleet  Object fleet
     * @return string|null  Return the fleet id or null if no result
     */
    public function getFleetId(Fleet $Fleet): string
    {
        foreach ($this->Fleet as $item) {
            if ($item->fleetId == $Fleet->fleetId()) {
                return $item->fleetId;
            }
        }
    }

    /**
     * This will check if a fleet exist
     *
     * @param Fleet $Fleet  Object fleet
     * @return integer  Return number of fleet who got the same fleet id
     */
    public function exist(Fleet $Fleet): int
    {
        $i = 0;
        foreach ($this->Fleet as $item) {
            if ($item->fleetId == $Fleet->fleetId()) {
                $i++;

                return $i;
            } else {
                return 0;
            }
        }
    }

    /**
     * This will save a fleet
     *
     * @param Fleet $Fleet  Object fleet
     */
    public function save(Fleet $Fleet): void
    {
        $this->Fleet[] = $Fleet;
    }
}
