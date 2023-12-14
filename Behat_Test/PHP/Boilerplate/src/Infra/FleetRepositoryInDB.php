<?php

namespace Behat_Test\Infra;

require_once  __DIR__ . '/../db_connection.php';

use Behat_Test\Domain\Interface\FleetRepositoryInterface;
use Behat_Test\Domain\ValueObject\Fleet;

class FleetRepositoryInDB implements FleetRepositoryInterface
{
    protected $Fleet;

    public function __construct()
    {
        $this->Fleet = [];
    }

    public function getAll(): array
    {
        $conn = OpenCon();

            $query = "SELECT * FROM fleet";
            $result = $conn->execute_query($query);

            return $result;

        CloseCon($conn);
    }

    public function getFleetId(Fleet $Fleet)
    {
        $conn = OpenCon();

            $query = "SELECT fleetId FROM fleet WHERE fleetId = '" . $Fleet->fleetId() . "'";
            $query_execute = $conn->execute_query($query);
            $result = $query_execute->fetch_object();

            return $result;

        CloseCon($conn);
    }

    public function exist(Fleet $Fleet)
    {
        $conn = OpenCon();

            $query = "SELECT COUNT(*) FROM fleet WHERE fleetId = '" . $Fleet->fleetId() . "'";
            $query_execute = $conn->execute_query($query);
            $query_fetch = $query_execute->fetch_assoc();
            $result = $query_fetch['COUNT(*)'];

            return $result;

        CloseCon($conn);
    }

    public function save(Fleet $Fleet): void
    {
        $conn = OpenCon();

            $query = "INSERT INTO fleet (fleetId) VALUES ('" . $Fleet->fleetId() . "')";
            $conn->execute_query($query);

        CloseCon($conn);
    }
}
