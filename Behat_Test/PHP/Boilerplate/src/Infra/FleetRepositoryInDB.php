<?php

namespace Behat_Test\Infra;

use Behat_Test\Domain\Interface\FleetRepositoryInterface;
use Behat_Test\Domain\ValueObject\Fleet;

class FleetRepositoryInDB implements FleetRepositoryInterface
{
    public function __construct()
    {
        require_once  __DIR__ . '/../db_connection.php';
    }

    /**
     * This will get the list of all the fleet registered
     *
     * @return array|null  Return the result array or null if no results
     */
    public function getAll(): array
    {
        $conn = OpenCon();

        $query = "SELECT * FROM fleet";
        $query_execute = $conn->execute_query($query);
        $result = $query_execute->fetch_assoc();

        return $result;

        CloseCon($conn);
    }

    /**
     * This will get the fleet id
     *
     * @param Fleet $Fleet  Object fleet
     * @return string|null  Return the fleet id or null if no result
     */
    public function getFleetId(Fleet $Fleet): object
    {
        $conn = OpenCon();

        $query = "SELECT fleetId FROM fleet WHERE fleetId = '" . $Fleet->fleetId() . "'";
        $query_execute = $conn->execute_query($query);
        $result = $query_execute->fetch_object();

        return $result;

        CloseCon($conn);
    }

    /**
     * This will check if a fleet exist
     *
     * @param Fleet $Fleet  Object fleet
     * @return integer  Return number of fleet who got the same fleet id
     */
    public function exist(Fleet $Fleet): int
    {
        $conn = OpenCon();

        $query = "SELECT COUNT(*) FROM fleet WHERE fleetId = '" . $Fleet->fleetId() . "'";
        $query_execute = $conn->execute_query($query);
        $query_fetch = $query_execute->fetch_assoc();
        $result = $query_fetch['COUNT(*)'];

        return $result;

        CloseCon($conn);
    }

    /**
     * This will save a fleet
     *
     * @param Fleet $Fleet  Object fleet
     */
    public function save(Fleet $Fleet): void
    {
        $conn = OpenCon();

        $query = "INSERT INTO fleet (fleetId) VALUES ('" . $Fleet->fleetId() . "')";
        $conn->execute_query($query);

        CloseCon($conn);
    }
}
