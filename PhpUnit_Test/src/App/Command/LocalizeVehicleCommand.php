<?php

namespace PhpUnit_Test\App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Valitron\Validator;
use PhpUnit_Test\App\Validators\LocalizeVehicleValidator;
use PhpUnit_Test\Infra\FleetRepositoryInDB;
use PhpUnit_Test\Domain\ValueObject\Fleet;
use PhpUnit_Test\App\Handler\LocalizeVehicleHandler;
use PhpUnit_Test\Infra\VehicleRepositoryInDB;
use PhpUnit_Test\Domain\ValueObject\Vehicle;
use PhpUnit_Test\Domain\ValueObject\Location;
use PhpUnit_Test\Infra\CQRS\ReadFleetRepository;
use PhpUnit_Test\Infra\CQRS\WriteFleetRepository;
use PhpUnit_Test\Infra\CQRS\ReadVehicleRepository;
use PhpUnit_Test\Infra\CQRS\WriteVehicleRepository;

// the name of the command is what users type after "php bin/console"
#[AsCommand(name: './fleet_localize_vehicle')]
class LocalizeVehicleCommand extends Command
{
    private $fleetId;
    private $plateNumber;

    private FleetRepositoryInDB $FleetRepository;
    private VehicleRepositoryInDB $VehicleRepository;

    private ReadFleetRepository $ReadFleetRepository;
    private WriteFleetRepository $WriteFleetRepository;

    private ReadVehicleRepository $ReadVehicleRepository;
    private WriteVehicleRepository $WriteVehicleRepository;

    public function __construct(bool $fleetId = false, bool $plateNumber = false)
    {
        $this->FleetRepository = new FleetRepositoryInDB();
        $this->VehicleRepository = new VehicleRepositoryInDB();

        $this->ReadFleetRepository = new ReadFleetRepository($this->FleetRepository);
        $this->WriteFleetRepository = new WriteFleetRepository($this->FleetRepository);

        $this->ReadVehicleRepository = new ReadVehicleRepository($this->VehicleRepository);
        $this->WriteVehicleRepository = new WriteVehicleRepository($this->VehicleRepository);

        $this->fleetId = $fleetId;
        $this->plateNumber = $plateNumber;

        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setHelp('This command allows you to localize a vehicle in a fleet');

        $this->addArgument('fleetId', InputArgument::REQUIRED, 'The Vehicle Fleet Id');
        $this->addArgument('plateNumber', InputArgument::REQUIRED, 'The Vehicle Plate Number');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        Validator::lang('en');
        $v = new LocalizeVehicleValidator(
            array(
                'fleetId' => $input->getArgument('fleetId'),
                'plateNumber' => $input->getArgument('plateNumber')
            )
        );

        if ($v->validate()) {
            //Check if Fleet exist
            $Fleet = new Fleet($input->getArgument('fleetId'));
            $checkFleet = $this->ReadFleetRepository->getFleetId($Fleet);
            if ($checkFleet !== 0) {
                //Check if Vehicle exist
                $Vehicle = new Vehicle($input->getArgument('fleetId'), $input->getArgument('plateNumber'), '0', '0');

                $checkVehicle = $this->ReadVehicleRepository->getThisVehicle($Vehicle);

                if ($checkVehicle === 0) {
                    $output->writeln(
                        [
                            'Vehicle Localize',
                            '============',
                            '',
                        ]
                    );

                    $output->write(
                        "Vehicle '" .
                            $input->getArgument('plateNumber') .
                            "' can't be localize because this vehicle doesn't exist"
                    );
                } else {
                    $LocalizeVehicleHandler = new LocalizeVehicleHandler(
                        $this->ReadFleetRepository,
                        $this->WriteFleetRepository,
                        $this->ReadVehicleRepository,
                        $this->WriteVehicleRepository
                    );
                    $LocalizeVehicleObject = new Vehicle(
                        $checkVehicle->fleetId,
                        $checkVehicle->plateNumber,
                        $checkVehicle->latitude,
                        $checkVehicle->longitude
                    );
                    $LocalizeLocationObject = new Location($checkVehicle->latitude, $checkVehicle->longitude);
                    $getLocalizeVehicle = $LocalizeVehicleHandler($LocalizeVehicleObject, $LocalizeLocationObject);
                    $output->writeln(
                        [
                            'Vehicle Localize',
                            '============',
                            '',
                        ]
                    );

                    $output->write(
                        "Vehicle '" .
                            $input->getArgument('plateNumber') .
                            "' is localize at Latitude : '" .
                            $getLocalizeVehicle->latitude .
                            "' and Longitude :  '" .
                            $getLocalizeVehicle->longitude . "'"
                    );
                }
            } else {
                $output->writeln(
                    [
                        'Vehicle Localize',
                        '============',
                        '',
                    ]
                );

                $output->write(
                    "Vehicle '" .
                        $input->getArgument('plateNumber') .
                    "' can't be localize because this Fleet '" .
                        $input->getArgument('fleetId') .
                    "' doesn't exist"
                );
            }

            return Command::SUCCESS;
        } else {
            $errors = $v->errors();

            $output->writeln(
                [
                    'Vehicle Localize',
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

            return Command::INVALID;
        }
    }
}
