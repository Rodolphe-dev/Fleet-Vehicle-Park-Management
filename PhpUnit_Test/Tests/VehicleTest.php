<?php

declare(strict_types=1);

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;
use PhpUnit_Test\App\Handler\CreateFleetHandler;
use PhpUnit_Test\App\Handler\RegisterVehicleHandler;
use PhpUnit_Test\App\Handler\ParkVehicleHandler;
use PhpUnit_Test\App\Handler\LocalizeVehicleHandler;
use PhpUnit_Test\Infra\FleetRepositoryInMemory;
use PhpUnit_Test\Infra\VehicleRepositoryInMemory;
use PhpUnit_Test\Infra\CQRS\ReadFleetRepository;
use PhpUnit_Test\Infra\CQRS\WriteFleetRepository;
use PhpUnit_Test\Infra\CQRS\ReadVehicleRepository;
use PhpUnit_Test\Infra\CQRS\WriteVehicleRepository;
use PhpUnit_Test\Domain\ValueObject\Fleet;
use PhpUnit_Test\Domain\ValueObject\Vehicle;
use PhpUnit_Test\Domain\ValueObject\Location;

/**
 * @coversDefaultClass \PhpUnit_Test\Domain\Interface\FleetRepositoryInterface
 */
class VehicleTest extends TestCase
{
    private Fleet $Fleet;
    private Vehicle $Vehicle;
    private Location $Location;

    private FleetRepositoryInMemory $fleetRepository;
    private VehicleRepositoryInMemory $vehicleRepository;
    private ReadFleetRepository $readFleetRepository;
    private WriteFleetRepository $writeFleetRepository;
    private ReadVehicleRepository $readVehicleRepository;
    private WriteVehicleRepository $writeVehicleRepository;

    protected function setUp(): void
    {
        $this->fleetRepository = new FleetRepositoryInMemory();
        $this->vehicleRepository = new VehicleRepositoryInMemory();
        $this->readFleetRepository = new ReadFleetRepository($this->fleetRepository);
        $this->writeFleetRepository = new WriteFleetRepository($this->fleetRepository);
        $this->readVehicleRepository = new ReadVehicleRepository($this->vehicleRepository);
        $this->writeVehicleRepository = new WriteVehicleRepository($this->vehicleRepository);
        $this->Fleet = new Fleet('JKL990');
        $fleetHandler = new CreateFleetHandler($this->readFleetRepository, $this->writeFleetRepository);
        $fleetHandlerValue = $fleetHandler($this->Fleet);
        $this->Vehicle = new Vehicle($this->Fleet->fleetId(), 'DK-672-GX', 1, 1);
        $this->Location = new Location(48.87, 2.31);
    }

    /**
     * @uses   \PhpUnit_Test\Domain\ValueObject\Fleet
     * @uses   \PhpUnit_Test\Domain\ValueObject\Vehicle
     * @uses   \PhpUnit_Test\App\Handler\RegisterVehicleHandler
     * @uses   \PhpUnit_Test\Infra\CQRS\ReadFleetRepository
     * @uses   \PhpUnit_Test\Infra\CQRS\WriteFleetRepository
     * @uses   \PhpUnit_Test\Infra\CQRS\ReadVehicleRepository
     * @uses   \PhpUnit_Test\Infra\CQRS\WriteVehicleRepository
     * @uses   \PhpUnit_Test\Infra\FleetRepositoryInMemory
     * @uses   \PhpUnit_Test\Infra\VehicleRepositoryInMemory
     */
    public function testRegisterVehicle()
    {
        $handler = new RegisterVehicleHandler(
            $this->readFleetRepository,
            $this->writeFleetRepository,
            $this->readVehicleRepository,
            $this->writeVehicleRepository
        );
        $handlerValue = $handler($this->Vehicle);
        $vehicleSaved = $this->readVehicleRepository->getThisVehicle($this->Vehicle);
        $this->assertNotEmpty($vehicleSaved);
        $this->assertEquals($this->Vehicle, $vehicleSaved);
    }

    /**
     * @uses   \PhpUnit_Test\Domain\ValueObject\Fleet
     * @uses   \PhpUnit_Test\Domain\ValueObject\Vehicle
     * @uses   \PhpUnit_Test\App\Handler\RegisterVehicleHandler
     * @uses   \PhpUnit_Test\Infra\CQRS\ReadFleetRepository
     * @uses   \PhpUnit_Test\Infra\CQRS\WriteFleetRepository
     * @uses   \PhpUnit_Test\Infra\CQRS\ReadVehicleRepository
     * @uses   \PhpUnit_Test\Infra\CQRS\WriteVehicleRepository
     * @uses   \PhpUnit_Test\Infra\FleetRepositoryInMemory
     * @uses   \PhpUnit_Test\Infra\VehicleRepositoryInMemory
     */
    public function testGetAllVehicle()
    {
        $handler = new RegisterVehicleHandler(
            $this->readFleetRepository,
            $this->writeFleetRepository,
            $this->readVehicleRepository,
            $this->writeVehicleRepository
        );
        $handlerValue = $handler($this->Vehicle);
        $vehicleList = $this->readVehicleRepository->getAll();
        $this->assertIsArray($vehicleList);
        $this->assertNotEmpty($vehicleList);
        $first = $vehicleList[0];
        $this->assertInstanceOf(Vehicle::class, $first);
    }

    /**
     * @uses   \PhpUnit_Test\Domain\ValueObject\Fleet
     * @uses   \PhpUnit_Test\Domain\ValueObject\Vehicle
     * @uses   \PhpUnit_Test\App\Handler\RegisterVehicleHandler
     * @uses   \PhpUnit_Test\Infra\CQRS\ReadFleetRepository
     * @uses   \PhpUnit_Test\Infra\CQRS\WriteFleetRepository
     * @uses   \PhpUnit_Test\Infra\CQRS\ReadVehicleRepository
     * @uses   \PhpUnit_Test\Infra\CQRS\WriteVehicleRepository
     * @uses   \PhpUnit_Test\Infra\FleetRepositoryInMemory
     * @uses   \PhpUnit_Test\Infra\VehicleRepositoryInMemory
     */
    public function testExistVehicle()
    {
        $handler = new RegisterVehicleHandler(
            $this->readFleetRepository,
            $this->writeFleetRepository,
            $this->readVehicleRepository,
            $this->writeVehicleRepository
        );
        $handlerValue = $handler($this->Vehicle);
        $vehicleExist = $this->readVehicleRepository->exist($this->Vehicle);
        $this->assertNotEmpty($vehicleExist);
        $this->assertIsInt($vehicleExist);
    }

    /**
     * @uses   \PhpUnit_Test\Domain\ValueObject\Fleet
     * @uses   \PhpUnit_Test\Domain\ValueObject\Vehicle
     * @uses   \PhpUnit_Test\App\Handler\RegisterVehicleHandler
     * @uses   \PhpUnit_Test\Infra\CQRS\ReadFleetRepository
     * @uses   \PhpUnit_Test\Infra\CQRS\WriteFleetRepository
     * @uses   \PhpUnit_Test\Infra\CQRS\ReadVehicleRepository
     * @uses   \PhpUnit_Test\Infra\CQRS\WriteVehicleRepository
     * @uses   \PhpUnit_Test\Infra\FleetRepositoryInMemory
     * @uses   \PhpUnit_Test\Infra\VehicleRepositoryInMemory
     */
    public function testGetThisVehicle()
    {
        $handler = new RegisterVehicleHandler(
            $this->readFleetRepository,
            $this->writeFleetRepository,
            $this->readVehicleRepository,
            $this->writeVehicleRepository
        );
        $handlerValue = $handler($this->Vehicle);
        $vehicleSaved = $this->readVehicleRepository->getThisVehicle($this->Vehicle);
        $this->assertNotEmpty($vehicleSaved);
        $this->assertNotEmpty($vehicleSaved->fleetId());
        $this->assertNotEmpty($vehicleSaved->plateNumber());
        $this->assertNotEmpty($vehicleSaved->latitude());
        $this->assertNotEmpty($vehicleSaved->longitude());
        $this->assertIsString($vehicleSaved->fleetId());
        $this->assertIsString($vehicleSaved->plateNumber());
        $this->assertIsFloat($vehicleSaved->latitude());
        $this->assertIsFloat($vehicleSaved->longitude());
        $this->assertEquals($this->Vehicle, $vehicleSaved);
    }

    /**
     * @uses   \PhpUnit_Test\Domain\ValueObject\Fleet
     * @uses   \PhpUnit_Test\Domain\ValueObject\Vehicle
     * @uses   \PhpUnit_Test\App\Handler\RegisterVehicleHandler
     * @uses   \PhpUnit_Test\App\Handler\ParkVehicleHandler
     * @uses   \PhpUnit_Test\Infra\CQRS\ReadFleetRepository
     * @uses   \PhpUnit_Test\Infra\CQRS\WriteFleetRepository
     * @uses   \PhpUnit_Test\Infra\CQRS\ReadVehicleRepository
     * @uses   \PhpUnit_Test\Infra\CQRS\WriteVehicleRepository
     * @uses   \PhpUnit_Test\Infra\FleetRepositoryInMemory
     * @uses   \PhpUnit_Test\Infra\VehicleRepositoryInMemory
     */
    public function testParkVehicle()
    {
        $handler = new RegisterVehicleHandler(
            $this->readFleetRepository,
            $this->writeFleetRepository,
            $this->readVehicleRepository,
            $this->writeVehicleRepository
        );
        $handlerValue = $handler($this->Vehicle);
        $parkVehicle = new Vehicle(
            $this->Fleet->fleetId(),
            $this->Vehicle->plateNumber(),
            $this->Location->latitude(),
            $this->Location->longitude()
        );
        $parkHandler = new ParkVehicleHandler(
            $this->readFleetRepository,
            $this->writeFleetRepository,
            $this->readVehicleRepository,
            $this->writeVehicleRepository
        );
        $parkHandlerValue = $parkHandler($parkVehicle);
        $vehicleSaved = $this->readVehicleRepository->getThisVehicle($this->Vehicle);
        $this->assertSame($this->Location->latitude(), $vehicleSaved->latitude());
        $this->assertSame($this->Location->longitude(), $vehicleSaved->longitude());
    }

    /**
     * @uses   \PhpUnit_Test\Domain\ValueObject\Fleet
     * @uses   \PhpUnit_Test\Domain\ValueObject\Vehicle
     * @uses   \PhpUnit_Test\App\Handler\RegisterVehicleHandler
     * @uses   \PhpUnit_Test\App\Handler\LocalizeVehicleHandler
     * @uses   \PhpUnit_Test\Infra\CQRS\ReadFleetRepository
     * @uses   \PhpUnit_Test\Infra\CQRS\WriteFleetRepository
     * @uses   \PhpUnit_Test\Infra\CQRS\ReadVehicleRepository
     * @uses   \PhpUnit_Test\Infra\CQRS\WriteVehicleRepository
     * @uses   \PhpUnit_Test\Infra\FleetRepositoryInMemory
     * @uses   \PhpUnit_Test\Infra\VehicleRepositoryInMemory
     */
    public function testLocalizeVehicle()
    {
        $handler = new RegisterVehicleHandler(
            $this->readFleetRepository,
            $this->writeFleetRepository,
            $this->readVehicleRepository,
            $this->writeVehicleRepository
        );
        $handlerValue = $handler($this->Vehicle);
        $parkVehicle = new Vehicle(
            $this->Fleet->fleetId(),
            $this->Vehicle->plateNumber(),
            $this->Location->latitude(),
            $this->Location->longitude()
        );
        $parkHandler = new ParkVehicleHandler(
            $this->readFleetRepository,
            $this->writeFleetRepository,
            $this->readVehicleRepository,
            $this->writeVehicleRepository
        );
        $parkHandlerValue = $parkHandler($parkVehicle);
        $localizeHandler = new LocalizeVehicleHandler(
            $this->readFleetRepository,
            $this->writeFleetRepository,
            $this->readVehicleRepository,
            $this->writeVehicleRepository
        );
        $localizeHandlerValue = $localizeHandler($parkHandlerValue, $this->Location);
        $vehicleSaved = $this->readVehicleRepository->getThisVehicle($this->Vehicle);
        $this->assertSame($this->Location->latitude(), $localizeHandlerValue->latitude());
        $this->assertSame($this->Location->longitude(), $localizeHandlerValue->longitude());
    }
}
