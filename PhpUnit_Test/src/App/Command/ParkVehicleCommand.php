<?php

namespace PhpUnit_Test\App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Valitron\Validator;
use PhpUnit_Test\App\Validators\ParkVehicleValidator;
use PhpUnit_Test\Infra\FleetRepositoryInDB;
use PhpUnit_Test\Domain\ValueObject\Fleet;
use PhpUnit_Test\App\Handler\ParkVehicleHandler;
use PhpUnit_Test\App\Handler\LocalizeVehicleHandler;
use PhpUnit_Test\Infra\VehicleRepositoryInDB;
use PhpUnit_Test\Domain\ValueObject\Vehicle;
use PhpUnit_Test\Infra\CQRS\ReadFleetRepository;
use PhpUnit_Test\Infra\CQRS\WriteFleetRepository;
use PhpUnit_Test\Infra\CQRS\ReadVehicleRepository;
use PhpUnit_Test\Infra\CQRS\WriteVehicleRepository;

// the name of the command is what users type after "php bin/console"
#[AsCommand(name: './fleet_park_vehicle')]
class ParkVehicleCommand extends Command
{
    private $fleetId;
    private $plateNumber;
    private $latitude;
    private $longitude;

    private Vehicle $Vehicle;

    private FleetRepositoryInDB $FleetRepository;
    private VehicleRepositoryInDB $VehicleRepository;

    private ReadFleetRepository $ReadFleetRepository;
    private WriteFleetRepository $WriteFleetRepository;

    private ReadVehicleRepository $ReadVehicleRepository;
    private WriteVehicleRepository $WriteVehicleRepository;

    public function __construct(
        bool $fleetId = false,
        bool $plateNumber = false,
        bool $latitude = false,
        bool $longitude = false
    ) {
        $this->FleetRepository = new FleetRepositoryInDB();
        $this->VehicleRepository = new VehicleRepositoryInDB();

        $this->ReadFleetRepository = new ReadFleetRepository($this->FleetRepository);
        $this->WriteFleetRepository = new WriteFleetRepository($this->FleetRepository);

        $this->ReadVehicleRepository = new ReadVehicleRepository($this->VehicleRepository);
        $this->WriteVehicleRepository = new WriteVehicleRepository($this->VehicleRepository);

        $this->fleetId = $fleetId;
        $this->plateNumber = $plateNumber;
        $this->latitude = $latitude;
        $this->longitude = $longitude;

        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setHelp('This command allows you to park a vehicle in a fleet');

        $this->addArgument('fleetId', InputArgument::REQUIRED, 'The Vehicle Fleet Id');
        $this->addArgument('plateNumber', InputArgument::REQUIRED, 'The Vehicle Plate Number');
        $this->addArgument('latitude', InputArgument::REQUIRED, 'The Vehicle park latitude');
        $this->addArgument('longitude', InputArgument::REQUIRED, 'The Vehicle park longitude');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        Validator::lang('en');
        $v = new ParkVehicleValidator(
            array(
                'fleetId' => $input->getArgument('fleetId'),
                'plateNumber' => $input->getArgument('plateNumber'),
                'latitude' => $input->getArgument('latitude'),
                'longitude' => $input->getArgument('longitude')
            )
        );

        if ($v->validate()) {
            //Check if Fleet exist
            $Fleet = new Fleet($input->getArgument('fleetId'));
            $checkFleet = $this->ReadFleetRepository->exist($Fleet);
            if ($checkFleet !== 0) {
                //Check if Vehicle exist
                $Vehicle = new Vehicle($input->getArgument('fleetId'), $input->getArgument('plateNumber'), '0', '0');

                $checkVehicle = $this->ReadVehicleRepository->exist($Vehicle);

                if ($checkVehicle === 0) {
                    $output->writeln(
                        [
                            'Vehicle Park',
                            '============',
                            '',
                        ]
                    );

                    $output->write(
                        "Vehicle '" .
                            $input->getArgument('plateNumber') .
                            "' can't be park because this vehicle doesn't exist"
                    );
                } else {
                    $ParkVehicleHandler = new ParkVehicleHandler(
                        $this->ReadFleetRepository,
                        $this->WriteFleetRepository,
                        $this->ReadVehicleRepository,
                        $this->WriteVehicleRepository
                    );
                    $ParkVehicle = new Vehicle(
                        $input->getArgument('fleetId'),
                        $input->getArgument('plateNumber'),
                        $input->getArgument('latitude'),
                        $input->getArgument('longitude')
                    );
                    $this->Vehicle = $ParkVehicleHandler($ParkVehicle);

                    $getVehicleAfterPark = $this->ReadVehicleRepository->getThisVehicle($Vehicle);

                    $output->writeln(
                        [
                            'Vehicle Park',
                            '============',
                            '',
                        ]
                    );

                    $output->write("Vehicle '" .
                        $input->getArgument('plateNumber') .
                        "' is park at Latitude : '" .
                        $getVehicleAfterPark->latitude .
                        "' and Longitude :  '" .
                        $getVehicleAfterPark->longitude . "'");
                }
            } else {
                $output->writeln(
                    [
                        'Vehicle Park',
                        '============',
                        '',
                    ]
                );

                $output->write(
                    "Vehicle '" .
                        $input->getArgument('plateNumber') .
                        "' can't be park because this Fleet '" .
                        $input->getArgument('fleetId') .
                        "' doesn't exist"
                );
            }

            return Command::SUCCESS;
        } else {
            $errors = $v->errors();

            $output->writeln(
                [
                    'Vehicle Park',
                    '============',
                    '',
                ]
            );

            $errors = $v->errors();
            if (!empty($errors['fleetId'])) {
                $output->writeln("Fleet Id" . $errors['fleetId']['0'] . "");
            }

            if (!empty($errors['plateNumber'])) {
                $output->write("Plate Number" . $errors['plateNumber']['0'] . "");
            }

            if (!empty($errors['latitude'])) {
                $output->write("Latitude" . $errors['latitude']['0'] . "");
            }

            if (!empty($errors['longitude'])) {
                $output->write("Longitude" . $errors['longitude']['0'] . "");
            }

            return Command::INVALID;
        }
    }
}
