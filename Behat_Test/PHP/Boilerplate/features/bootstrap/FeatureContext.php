<?php
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;

use Behat_Test\App\Handler\CreateFleetHandler;
use Behat_Test\Infra\FleetRepositoryInDB;
use Behat_Test\Domain\ValueObject\Fleet;

use Behat_Test\App\Handler\RegisterVehicleHandler;
use Behat_Test\Infra\VehicleRepositoryInDB;
use Behat_Test\Domain\ValueObject\Vehicle;

use Behat_Test\App\Handler\ParkVehicleHandler;
use Behat_Test\Domain\ValueObject\Location;

use Behat_Test\App\Handler\LocalizeVehicleHandler;

use Behat_Test\Infra\CQRS\ReadFleetRepository;
use Behat_Test\Infra\CQRS\WriteFleetRepository;
use Behat_Test\Infra\CQRS\ReadVehicleRepository;
use Behat_Test\Infra\CQRS\WriteVehicleRepository;

/**
 * Defines application features from the specific context.
 */
class FeatureContext implements Context
{
    private Fleet $Fleet;
    private Fleet $Fleet2;
    private Fleet $AnotherFleet;
    private Vehicle $Vehicle;
    private Vehicle $Vehicle1;
    private Vehicle $Vehicle2;
    private Vehicle $ParkVehicle;
    private string $PlateNumber;
    private Location $Location;

    private FleetRepositoryInDB $FleetRepository;
    private VehicleRepositoryInDB $VehicleRepository;

    private ReadFleetRepository $ReadFleetRepository;
    private WriteFleetRepository $WriteFleetRepository;

    private ReadVehicleRepository $ReadVehicleRepository;
    private WriteVehicleRepository $WriteVehicleRepository;

    public function __construct()
    {
        $this->FleetRepository = new FleetRepositoryInDB();
        $this->VehicleRepository = new VehicleRepositoryInDB();

        $this->ReadFleetRepository = new ReadFleetRepository($this->FleetRepository);
        $this->WriteFleetRepository = new WriteFleetRepository($this->FleetRepository);

        $this->ReadVehicleRepository = new ReadVehicleRepository($this->VehicleRepository);
        $this->WriteVehicleRepository = new WriteVehicleRepository($this->VehicleRepository);

        $CreateFleetHandler = new CreateFleetHandler($this->ReadFleetRepository, $this->WriteFleetRepository);
        $RegisterVehicleHandler = new RegisterVehicleHandler($this->ReadFleetRepository, $this->WriteFleetRepository, $this->ReadVehicleRepository, $this->WriteVehicleRepository);
        $ParkVehicleHandler = new ParkVehicleHandler($this->ReadFleetRepository, $this->WriteFleetRepository, $this->ReadVehicleRepository, $this->WriteVehicleRepository);
        $LocalizeVehicleHandler = new LocalizeVehicleHandler($this->ReadFleetRepository, $this->WriteFleetRepository, $this->ReadVehicleRepository, $this->WriteVehicleRepository);
    }

    /* REGISTER VEHICLE FEATURE */

    /**
     * @Given my fleet
     */
    public function myFleet()
    {
        $FleetHandler = new CreateFleetHandler($this->ReadFleetRepository, $this->WriteFleetRepository);
        $IdFleet = new Fleet('JKL980');
        $this->Fleet = $FleetHandler($IdFleet);
    }

    /**
     * @Given a vehicle
     */
    public function aVehicle()
    {
        $this->PlateNumber = 'DK-672-GX';
    }

    /**
     * @When I register this vehicle into my fleet
     */
    public function iRegisterThisVehicleIntoMyFleet()
    {
        $RegisterVehicleHandler = new RegisterVehicleHandler($this->ReadFleetRepository, $this->WriteFleetRepository, $this->ReadVehicleRepository, $this->WriteVehicleRepository);
        $Vehicle = new Vehicle($this->Fleet->fleetId(), $this->PlateNumber, '0', '0');
        $this->Vehicle = $RegisterVehicleHandler($Vehicle);
    }

    /**
     * @Then this vehicle should be part of my vehicle fleet
     */
    public function thisVehicleShouldBePartOfMyVehicleFleet()
    {
        if($this->Fleet->fleetId() !== $this->Vehicle->FleetId()) {
            echo 'This vehicle isn\t register in my fleet';
        }else{
            echo 'This vehicle is register into my fleet';
        }
    }

    /**
     * @Given I have registered this vehicle into my fleet
     */
    public function iHaveRegisteredThisVehicleIntoMyFleet()
    {
        $RegisterVehicleHandler = new RegisterVehicleHandler($this->ReadFleetRepository, $this->WriteFleetRepository, $this->ReadVehicleRepository, $this->WriteVehicleRepository);
        $Vehicle1 = new Vehicle($this->Fleet->fleetId(), $this->PlateNumber, '0', '0');
        $this->Vehicle1 = $RegisterVehicleHandler($Vehicle1);
    }

    /**
     * @When I try to register this vehicle into my fleet
     */
    public function iTryToRegisterThisVehicleIntoMyFleet()
    {
        $RegisterVehicleHandler = new RegisterVehicleHandler($this->ReadFleetRepository, $this->WriteFleetRepository, $this->ReadVehicleRepository, $this->WriteVehicleRepository);
        $Vehicle2 = new Vehicle($this->Fleet->fleetId(), $this->PlateNumber, '0', '0');
        $this->Vehicle2 = $RegisterVehicleHandler($Vehicle2);
    }

    /**
     * @Then I should be informed this this vehicle has already been registered into my fleet
     */
    public function iShouldBeInformedThisThisVehicleHasAlreadyBeenRegisteredIntoMyFleet()
    {
        if($this->Vehicle1->FleetId() === $this->Vehicle2->FleetId() and $this->Vehicle1->PlateNUmber() === $this->Vehicle2->PlateNUmber()) {
            echo 'This vehicle is already register into my fleet';
        }else {
            echo 'This vehicle is register';
        }
    }

    /**
     * @Given the fleet of another user
     */
    public function theFleetOfAnotherUser()
    {
        $FleetHandler = new CreateFleetHandler($this->ReadFleetRepository, $this->WriteFleetRepository);
        $IdFleet = new Fleet('ZOR769');
        $this->AnotherFleet = $FleetHandler($IdFleet);
    }

    /**
     * @Given this vehicle has been registered into the other user's fleet
     */
    public function thisVehicleHasBeenRegisteredIntoTheOtherUsersFleet()
    {
        $RegisterVehicleHandler = new RegisterVehicleHandler($this->ReadFleetRepository, $this->WriteFleetRepository, $this->ReadVehicleRepository, $this->WriteVehicleRepository);
        $Vehicle = new Vehicle($this->AnotherFleet->fleetId(), $this->PlateNumber, '0', '0');
        $this->Vehicle = $RegisterVehicleHandler($Vehicle);
    }

    /* PARK VEHICLE FEATURE */

    /**
     * @Given a location
     */
    public function aLocation()
    {
        $this->Location = new Location(48.87, 2.31);
    }

    /**
     * @When I park my vehicle at this location
     */
    public function iParkMyVehicleAtThisLocation()
    {
        $RegisterVehicleHandler = new RegisterVehicleHandler($this->ReadFleetRepository, $this->WriteFleetRepository, $this->ReadVehicleRepository, $this->WriteVehicleRepository);
        $Vehicle = new Vehicle($this->Fleet->fleetId(), $this->PlateNumber, '0', '0');
        $this->Vehicle = $RegisterVehicleHandler($Vehicle);

        $ParkVehicleHandler = new ParkVehicleHandler($this->ReadFleetRepository, $this->WriteFleetRepository, $this->ReadVehicleRepository, $this->WriteVehicleRepository);
        $ParkVehicle = new Vehicle($this->Fleet->fleetId(), $this->PlateNumber, $this->Location->latitude(), $this->Location->longitude());
        $this->ParkVehicle = $ParkVehicleHandler($ParkVehicle);
    }

    /**
     * @Then the known location of my vehicle should verify this location
     */
    public function theKnownLocationOfMyVehicleShouldVerifyThisLocation()
    {
        $LocalizeVehicleHandler = new LocalizeVehicleHandler($this->ReadFleetRepository, $this->WriteFleetRepository, $this->ReadVehicleRepository, $this->WriteVehicleRepository);
        $LocalizeVehicle = $LocalizeVehicleHandler($this->ParkVehicle, $this->Location);

        if($LocalizeVehicle->latitude === $this->Location->latitude() and $LocalizeVehicle->longitude === $this->Location->longitude()) {
            echo 'This vehicle is park at the location';
        }else {
            echo 'This vehicle is not park at the location';
        }
        
    }

    /**
     * @Given my vehicle has been parked into this location
     */
    public function myVehicleHasBeenParkedIntoThisLocation()
    {
        $RegisterVehicleHandler = new RegisterVehicleHandler($this->ReadFleetRepository, $this->WriteFleetRepository, $this->ReadVehicleRepository, $this->WriteVehicleRepository);
        $Vehicle = new Vehicle($this->Fleet->fleetId(), $this->PlateNumber, '0', '0');
        $this->Vehicle = $RegisterVehicleHandler($Vehicle);

        $ParkVehicleHandler = new ParkVehicleHandler($this->ReadFleetRepository, $this->WriteFleetRepository, $this->ReadVehicleRepository, $this->WriteVehicleRepository);
        $ParkVehicle = new Vehicle($this->Fleet->fleetId(), $this->PlateNumber, $this->Location->latitude(), $this->Location->longitude());
        $this->ParkVehicle = $ParkVehicleHandler($ParkVehicle);
    }

    /**
     * @When I try to park my vehicle at this location
     */
    public function iTryToParkMyVehicleAtThisLocation()
    {
        $reParkVehicleHandler = new ParkVehicleHandler($this->ReadFleetRepository, $this->WriteFleetRepository, $this->ReadVehicleRepository, $this->WriteVehicleRepository);
        $reParkVehicle = $reParkVehicleHandler($this->ParkVehicle);
    }

    /**
     * @Then I should be informed that my vehicle is already parked at this location
     */
    public function iShouldBeInformedThatMyVehicleIsAlreadyParkedAtThisLocation()
    {
        $LocalizeVehicleHandler = new LocalizeVehicleHandler($this->ReadFleetRepository, $this->WriteFleetRepository, $this->ReadVehicleRepository, $this->WriteVehicleRepository);
        $LocalizeVehicle = $LocalizeVehicleHandler($this->ParkVehicle, $this->Location);

        if($LocalizeVehicle->latitude === $this->Location->latitude and $LocalizeVehicle->longitude === $this->Location->longitude) {
            echo 'This vehicle is already park at this location';
        }else {
            $ParkVehicleHandler = new ParkVehicleHandler($this->ReadFleetRepository, $this->WriteFleetRepository, $this->ReadVehicleRepository, $this->WriteVehicleRepository);
            $ParkVehicle = new Vehicle($this->Fleet->fleetId(), $this->PlateNumber, $this->Location->latitude(), $this->Location->longitude());
            $this->ParkVehicle = $ParkVehicleHandler($ParkVehicle);

            echo 'This vehicle is park at this location';
        }
    }
}
?>