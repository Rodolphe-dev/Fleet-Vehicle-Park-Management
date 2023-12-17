<?php
declare(strict_types=1);

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;

use PHPUnit\Framework\TestCase;

use PhpUnit_Test\App\Handler\CreateFleetHandler;
use PhpUnit_Test\Infra\FleetRepositoryInMemory;
use PhpUnit_Test\Infra\CQRS\ReadFleetRepository;
use PhpUnit_Test\Infra\CQRS\WriteFleetRepository;
use PhpUnit_Test\Domain\ValueObject\Fleet;

/**
 * @coversDefaultClass \PhpUnit_Test\Domain\Interface\FleetRepositoryInterface
 */
class FleetTest extends TestCase{

    protected function setUp() : void
    {
        $this->fleetRepository = new FleetRepositoryInMemory();
        $this->readFleetRepository = new ReadFleetRepository($this->fleetRepository);
        $this->writeFleetRepository = new WriteFleetRepository($this->fleetRepository);
        
        $this->Fleet = new Fleet('JKL990');
    }

    /**
     * @uses   \PhpUnit_Test\Domain\ValueObject\Fleet
     * @uses   \PhpUnit_Test\App\Handler\CreateFleetHandler
     * @uses   \PhpUnit_Test\Infra\CQRS\ReadFleetRepository
     * @uses   \PhpUnit_Test\Infra\CQRS\WriteFleetRepository
     * @uses   \PhpUnit_Test\Infra\FleetRepositoryInMemory
     */
    public function testCreateFleet()
    {
        $handler = new CreateFleetHandler($this->readFleetRepository, $this->writeFleetRepository);
        $handlerValue = $handler($this->Fleet);

        $fleetSaved = $this->readFleetRepository->getFleetId($this->Fleet);

        $this->assertNotEmpty($fleetSaved);
        $this->assertSame($this->Fleet->fleetId(), $fleetSaved); 
    }

    /**
     * @uses   \PhpUnit_Test\Domain\ValueObject\Fleet
     * @uses   \PhpUnit_Test\App\Handler\CreateFleetHandler
     * @uses   \PhpUnit_Test\Infra\CQRS\ReadFleetRepository
     * @uses   \PhpUnit_Test\Infra\CQRS\WriteFleetRepository
     * @uses   \PhpUnit_Test\Infra\FleetRepositoryInMemory
     */
    public function testGetAllFleet()
    {
        $handler = new CreateFleetHandler($this->readFleetRepository, $this->writeFleetRepository);
        $handlerValue = $handler($this->Fleet);

        $fleetList = $this->readFleetRepository->getAll();

        $this->assertIsArray($fleetList);
        $this->assertNotEmpty($fleetList);

        $first=$fleetList[0];

        $this->assertInstanceOf(Fleet::class,$first);
    }

    /**
     * @uses   \PhpUnit_Test\Domain\ValueObject\Fleet
     * @uses   \PhpUnit_Test\App\Handler\CreateFleetHandler
     * @uses   \PhpUnit_Test\Infra\CQRS\ReadFleetRepository
     * @uses   \PhpUnit_Test\Infra\CQRS\WriteFleetRepository
     * @uses   \PhpUnit_Test\Infra\FleetRepositoryInMemory
     */
    public function testExistFleet()
    {
        $handler = new CreateFleetHandler($this->readFleetRepository, $this->writeFleetRepository);
        $handlerValue = $handler($this->Fleet);

        $fleetExist = $this->readFleetRepository->exist($this->Fleet);
        
        $this->assertNotEmpty($fleetExist);
        $this->assertIsInt($fleetExist);
    }

    /**
     * @uses   \PhpUnit_Test\Domain\ValueObject\Fleet
     * @uses   \PhpUnit_Test\App\Handler\CreateFleetHandler
     * @uses   \PhpUnit_Test\Infra\CQRS\ReadFleetRepository
     * @uses   \PhpUnit_Test\Infra\CQRS\WriteFleetRepository
     * @uses   \PhpUnit_Test\Infra\FleetRepositoryInMemory
     */
    public function testGetFleetId()
    {
        $handler = new CreateFleetHandler($this->readFleetRepository, $this->writeFleetRepository);
        $handlerValue = $handler($this->Fleet);

        $fleetGetId = $this->readFleetRepository->getFleetId($this->Fleet);
        
        $this->assertNotEmpty($fleetGetId);
        $this->assertIsString($fleetGetId);
        $this->assertSame($this->Fleet->fleetId(), $fleetGetId); 
    }
}