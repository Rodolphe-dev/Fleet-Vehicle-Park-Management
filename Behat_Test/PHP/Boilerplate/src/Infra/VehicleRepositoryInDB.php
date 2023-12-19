<?php

namespace Behat_Test\Infra;

use Behat_Test\Domain\Interface\VehicleRepositoryInterface;
use Behat_Test\Domain\ValueObject\Vehicle;

class VehicleRepositoryInDB implements VehicleRepositoryInterface
{
    protected $Vehicle;

    public function __construct()
    {
        require_once  __DIR__ . '/../db_connection.php';

        $this->Vehicle = [];
    }

    public function getAll(): array
    {
        $conn = OpenCon();

        $query = "SELECT * FROM vehicle";
        $query_execute = $conn->execute_query($query);
        $result = $query_execute->fetch_assoc();

        return $result;

        CloseCon($conn);
    }

    public function getThisVehicle(Vehicle $Vehicle): object
    {
        $conn = OpenCon();

        $query =
            "SELECT * 
            FROM vehicle 
            WHERE fleetId = '" . $Vehicle->fleetId() . "' AND plateNumber = '" . $Vehicle->plateNumber() . "'";

        $query_execute = $conn->execute_query($query);
        $result = $query_execute->fetch_object();

        return $result;

        CloseCon($conn);
    }

    public function exist(Vehicle $Vehicle): int
    {
        $conn = OpenCon();

        $query =
            "SELECT COUNT(*) 
            FROM vehicle 
            WHERE fleetId = '" . $Vehicle->fleetId() . "' AND plateNumber = '" . $Vehicle->plateNumber() . "'";

        $query_execute = $conn->execute_query($query);
        $query_fetch = $query_execute->fetch_assoc();
        $result = $query_fetch['COUNT(*)'];

        return $result;

        CloseCon($conn);
    }

    public function save(Vehicle $Vehicle): void
    {
        $conn = OpenCon();

        $query =
            "INSERT INTO vehicle (fleetId, plateNumber, latitude, longitude) 
            VALUES 
            ('" . $Vehicle->fleetId() . "', 
            '" . $Vehicle->plateNumber() . "', 
            '" . $Vehicle->latitude() . "', 
            '" . $Vehicle->longitude() . "')";

        $conn->execute_query($query);

        CloseCon($conn);
    }

    public function park(Vehicle $Vehicle)
    {
        $conn = OpenCon();

        $query =
            "UPDATE vehicle 
            SET latitude = '" . $Vehicle->latitude() . "', longitude = '" . $Vehicle->longitude() . "' 
            WHERE fleetId = '" . $Vehicle->fleetId() . "' AND plateNumber = '" . $Vehicle->plateNumber() . "'";

        $conn->query($query);

        $getVehicleQuery =
            "SELECT * 
            FROM vehicle 
            WHERE plateNumber = '" . $Vehicle->plateNumber() . "'";

        $getVehicleResult = $conn->execute_query($getVehicleQuery);

        return $getVehicleResult;

        CloseCon($conn);
    }
}
