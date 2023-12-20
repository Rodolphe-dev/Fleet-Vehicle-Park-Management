<?php

namespace Behat_Test\Domain\Interface;

use Behat_Test\Domain\ValueObject\Fleet;

interface FleetRepositoryInterface
{
    /**
     * This will get the list of all the fleet registered
     *
     * @return array|null  Return the result array or null if no results
     */
    public function getAll(): array;

    /**
     * This will get the fleet id
     *
     * @param Fleet $Fleet  Object fleet
     * @return object|null  Return the fleet id or null if no result
     */
    public function getFleetId(Fleet $Fleet): object;

    /**
     * This will check if a fleet exist
     *
     * @param Fleet $Fleet  Object fleet
     * @return integer  Return number of fleet who got the same fleet id
     */
    public function exist(Fleet $Fleet): int;

    /**
     * This will save a fleet
     *
     * @param Fleet $Fleet  Object fleet
     */
    public function save(Fleet $Fleet): void;
}
